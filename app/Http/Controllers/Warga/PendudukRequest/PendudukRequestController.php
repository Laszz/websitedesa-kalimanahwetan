<?php

namespace App\Http\Controllers\Warga\PendudukRequest;

use App\Http\Controllers\Controller;
use App\Models\LayananPenduduk;
use App\Models\PendudukRequest;
use App\Models\PendudukRequirement;
use App\Models\PendudukUpload;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PendudukRequestController extends Controller
{
    // ===============================
    // INDEX - LIST PENGAJUAN WARGA
    // ===============================
    public function index()
    {
        $requests = PendudukRequest::with('layanan')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        return view('warga.pendudukrequest.index', compact('requests', 'notifications'));
    }

    // ===============================
    // CREATE - FORM PENGAJUAN
    // ===============================
    public function create($layananId)
    {
        $layanan = LayananPenduduk::findOrFail($layananId);
        $requirements = PendudukRequirement::where('layanan_id', $layananId)->get();

        return view('warga.pendudukrequest.create', [
            'layanan'      => $layanan,
            'requirements' => $requirements,
        ]);
    }

    // ===============================
    // SHOW - DETAIL PENGAJUAN
    // ===============================
    public function show($id)
    {
        $request = PendudukRequest::with([
                'layanan',
                'uploads.requirement'
            ])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $uploadedRequirementIds = $request->uploads
            ->pluck('requirement_id')
            ->toArray();
        
        $availableRequirements = PendudukRequirement::where(
            'layanan_id',
            $request->layanan_id
        )
        ->whereNotIn('id', $uploadedRequirementIds)
        ->get();

        return view('warga.pendudukrequest.show', compact('request', 'availableRequirements'));
    }

    // ===============================
    // STORE - SIMPAN PERMOHONAN
    // ===============================
    public function store(Request $request)
    {
        try {
            $request->validate([
                'layanan_id'   => 'required|exists:layanan_penduduks,id',
                'catatan_user' => 'nullable|string|max:1000',
            ]);

            $requirements = PendudukRequirement::where('layanan_id', $request->layanan_id)->get();
            $rules = [];
            $messages = [];

            foreach ($requirements as $req) {
                if ($req->tipe === 'file') {
                    $rules['files.' . $req->id] = 'required|file|mimes:jpg,jpeg,png,pdf|max:5120';
                    $messages['files.' . $req->id . '.required'] = 'File "' . $req->nama . '" wajib diupload.';
                    $messages['files.' . $req->id . '.file'] = 'File "' . $req->nama . '" tidak valid.';
                    $messages['files.' . $req->id . '.mimes'] = 'File "' . $req->nama . '" harus berformat JPG, JPEG, PNG, atau PDF.';
                    $messages['files.' . $req->id . '.max'] = 'File "' . $req->nama . '" terlalu besar! Ukuran file Anda melebihi 5 MB.';
                }
                if ($req->tipe === 'text') {
                    $rules['texts.' . $req->id] = 'required|string|max:255';
                    $messages['texts.' . $req->id . '.required'] = 'Field "' . $req->nama . '" wajib diisi.';
                    $messages['texts.' . $req->id . '.max'] = 'Field "' . $req->nama . '" maksimal 255 karakter.';
                }
            }

            $request->validate($rules, $messages);

            $pendudukRequest = PendudukRequest::create([
                'user_id'        => Auth::id(),
                'layanan_id'     => $request->layanan_id,
                'nomor_request'  => 'REQ-' . now()->format('YmdHis') . '-' . Auth::id(),
                'status'         => 'pending',
                'catatan_user'   => $request->catatan_user,
            ]);

            foreach ($requirements as $req) {
                if ($req->tipe === 'file' && $request->hasFile('files.' . $req->id)) {
                    $file = $request->file('files.' . $req->id);
                    $path = $file->store('penduduk_uploads', 'public');

                    PendudukUpload::create([
                        'request_id'     => $pendudukRequest->id,
                        'requirement_id' => $req->id,
                        'file_path'      => $path,
                    ]);
                }

                if ($req->tipe === 'text') {
                    PendudukUpload::create([
                        'request_id'     => $pendudukRequest->id,
                        'requirement_id' => $req->id,
                        'value_text'     => $request->input('texts.' . $req->id),
                    ]);
                }
            }

            return redirect()
                ->route('warga.pendudukrequest.index')
                ->with('success', 'Permohonan berhasil diajukan!');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ===============================
    // UPDATE UPLOAD (FIXED - LOGGING + FORCE UPDATE)
    // ===============================
    public function updateUpload(Request $request, $uploadId)
    {
        try {
            $upload = PendudukUpload::with('request', 'requirement')
                ->findOrFail($uploadId);

            if ($upload->request->user_id !== Auth::id()) {
                abort(403);
            }

            if (!in_array($upload->request->status, ['pending', 'review', 'rejected'])) {
                return back()->with('error', 'Berkas tidak dapat diedit.');
            }

            if ($upload->requirement->tipe === 'file') {

                $request->validate([
                    'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
                ], [
                    'file.required' => 'File wajib diupload.',
                    'file.file' => 'File yang diupload tidak valid.',
                    'file.mimes' => 'Format file harus JPG, PNG, atau PDF.',
                    'file.max' => 'File terlalu besar! Ukuran file Anda melebihi 5 MB.',
                ]);

                // HAPUS file lama
                $oldPath = $upload->file_path;
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                    \Log::info('EDIT UPLOAD - Old file deleted', ['path' => $oldPath]);
                }

                // Simpan file baru
                $newPath = $request->file('file')->store('penduduk_uploads', 'public');
                \Log::info('EDIT UPLOAD - New file stored', ['path' => $newPath]);

                // FORCE UPDATE database
                $upload->file_path = $newPath;
                $upload->save();

                \Log::info('EDIT UPLOAD - DB updated', [
                    'upload_id' => $uploadId,
                    'old_path' => $oldPath,
                    'new_path' => $newPath,
                    'was_changed' => $upload->wasChanged('file_path'),
                ]);

            } else {

                $request->validate([
                    'value_text' => 'required|string|max:255',
                ], [
                    'value_text.required' => 'Teks wajib diisi.',
                    'value_text.max' => 'Teks maksimal 255 karakter.',
                ]);

                $upload->update([
                    'value_text' => $request->value_text,
                ]);
            }

            return back()->with('success', 'Berkas berhasil diperbarui.');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('EDIT UPLOAD ERROR', ['message' => $e->getMessage()]);
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ===============================
    // HAPUS UPLOAD
    // ===============================
    public function destroyUpload($uploadId)
    {
        $upload = PendudukUpload::with('request')
            ->findOrFail($uploadId);

        if ($upload->request->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($upload->request->status, ['pending', 'review', 'rejected'])) {
            return back()->with('error', 'Berkas tidak dapat dihapus.');
        }

        if (
            $upload->file_path &&
            Storage::disk('public')->exists($upload->file_path)
        ) {
            Storage::disk('public')->delete($upload->file_path);
        }

        $upload->delete();

        return back()->with('success', 'Berkas berhasil dihapus.');
    }

    // ===============================
    // TAMBAH UPLOAD BARU
    // ===============================
    public function addUpload(Request $request, $requestId)
    {
        try {
            $pendudukRequest = PendudukRequest::with('uploads')
                ->findOrFail($requestId);

            if ($pendudukRequest->user_id !== Auth::id()) {
                abort(403);
            }

            if (!in_array($pendudukRequest->status, ['pending', 'review', 'rejected'])) {
                return back()->with('error', 'Tidak dapat menambah berkas.');
            }

            $request->validate([
                'requirement_id' => 'required|exists:penduduk_requirements,id',
                'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'value_text' => 'nullable|string|max:255',
            ], [
                'file.mimes' => 'Format file harus JPG, PNG, atau PDF.',
                'file.max' => 'File terlalu besar! Ukuran file Anda melebihi 5 MB.',
                'value_text.max' => 'Teks maksimal 255 karakter.',
            ]);

            $requirement = PendudukRequirement::findOrFail(
                $request->requirement_id
            );

            $data = [
                'request_id' => $pendudukRequest->id,
                'requirement_id' => $requirement->id,
            ];

            if ($requirement->tipe === 'file') {

                if (!$request->hasFile('file')) {
                    return back()->with('error', 'File wajib diupload.');
                }

                $data['file_path'] = $request->file('file')
                    ->store('penduduk_uploads', 'public');

            } else {

                $data['value_text'] = $request->value_text;
            }

            PendudukUpload::create($data);

            return back()->with('success', 'Berkas berhasil ditambahkan.');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ===============================
    // VIEW FILE (UPLOAD WARGA)
    // ===============================
    public function viewFile($id)
    {
        $upload = PendudukUpload::with('request')->findOrFail($id);

        if ($upload->request->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak');
        }

        if (!$upload->file_path || !Storage::disk('public')->exists($upload->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->file(storage_path('app/public/' . $upload->file_path));
    }

    // ===============================
    // DOWNLOAD FILE OUTPUT (ADMIN)
    // ===============================
    public function download($id)
    {
        $request = PendudukRequest::where('user_id', Auth::id())
            ->findOrFail($id);

        if (!$request->file_output || !Storage::disk('public')->exists($request->file_output)) {
            abort(404, 'File belum tersedia');
        }

        return Storage::disk('public')->download($request->file_output);
    }
}