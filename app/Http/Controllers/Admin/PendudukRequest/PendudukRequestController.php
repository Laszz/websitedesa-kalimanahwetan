<?php

namespace App\Http\Controllers\Admin\PendudukRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PendudukRequest;
use App\Models\Notification;

class PendudukRequestController extends Controller
{
    // ===============================
    // INDEX - LIST SEMUA PENGAJUAN
    // ===============================
    public function index()
    {
        $requests = PendudukRequest::with('layanan', 'user.warga')
            ->latest()
            ->get();

        return view('admin.pendudukrequest.index', compact('requests'));
    }

    // ===============================
    // SHOW - DETAIL PENGAJUAN
    // ===============================
    public function show($id)
    {
        $requestData = PendudukRequest::with([
                'layanan',
                'user.warga',
                'uploads.requirement'
            ])
            ->findOrFail($id);

        return view('admin.pendudukrequest.show', compact('requestData'));
    }

    // ===============================
    // EDIT - FORM UPDATE STATUS
    // ===============================
    public function edit($id)
    {
        $requestData = PendudukRequest::with('user.warga', 'layanan')
            ->findOrFail($id);

        return view('admin.pendudukrequest.edit', compact('requestData'));
    }

    // ===============================
    // UPDATE - SIMPAN STATUS & CATATAN
    // ===============================
    public function update(Request $request, $id)
    {
        $requestData = PendudukRequest::findOrFail($id);
        $oldStatus = $requestData->status;
        $hadFile = !empty($requestData->file_output);

        $request->validate([
            'status'        => 'required|in:pending,review,approved,rejected,selesai',
            'catatan_admin' => 'nullable|string|max:1000',
            'file_output'   => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $requestData->status = $request->status;
        $requestData->catatan_admin = $request->catatan_admin;
        if ($request->status !== 'selesai') {
    $requestData->tanggal_selesai = null;
}

        // ===============================
        // HANDLE UPLOAD PDF
        // ===============================
        $newFileUploaded = false;

        if ($request->hasFile('file_output')) {
            if (!empty($requestData->file_output) && Storage::disk('public')->exists($requestData->file_output)) {
                Storage::disk('public')->delete($requestData->file_output);
            }

            $file = $request->file('file_output');
            $path = $file->store('penduduk_output', 'public');

            $requestData->file_output = $path;
            $requestData->status = 'selesai';
            $requestData->tanggal_selesai = now();
            
            $newFileUploaded = true;
        }

        $requestData->save();

        // ===============================
        // 🔔 NOTIF (ANTI SPAM)
        // ===============================
        $statusChanged = ($oldStatus !== $requestData->status);
        $fileChanged = $newFileUploaded;

        if ($statusChanged || $fileChanged) {
            $message = $this->getStatusMessage($requestData);

            Notification::create([
                'user_id' => $requestData->user_id,
                'title'   => 'Update Pengajuan Layanan',
                'message' => $message,
                'url'     => route('warga.pendudukrequest.show', $requestData->id),
                'is_read' => false,
            ]);

            return redirect()
                ->route('admin.pendudukrequest.index')
                ->with('success', $message);
        }

        return redirect()
            ->route('admin.pendudukrequest.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    // ===============================
    // DESTROY - HAPUS PENGAJUAN
    // ===============================
    public function destroy($id)
    {
        $requestData = PendudukRequest::findOrFail($id);

        foreach ($requestData->uploads as $upload) {
            if (!empty($upload->file_path) && Storage::disk('public')->exists($upload->file_path)) {
                Storage::disk('public')->delete($upload->file_path);
            }
        }

        if (!empty($requestData->file_output) && Storage::disk('public')->exists($requestData->file_output)) {
            Storage::disk('public')->delete($requestData->file_output);
        }

        $requestData->uploads()->delete();
        $requestData->delete();

        return redirect()
            ->route('admin.pendudukrequest.index')
            ->with('success', 'Permohonan berhasil dihapus!');
    }

    // ===============================
    // HELPER - PESAN NOTIFIKASI
    // ===============================
    private function getStatusMessage($requestData)
    {
        return match($requestData->status) {
            'review'    => 'Pengajuan kamu sedang direview admin',
            'approved'  => 'Pengajuan kamu disetujui dan sedang diproses',
            'rejected'  => 'Pengajuan kamu ditolak',
            'selesai'   => $requestData->file_output 
                            ? 'Dokumen kamu sudah selesai dan bisa didownload' 
                            : 'Status pengajuan diperbarui',
            default     => 'Status pengajuan diperbarui',
        };
    }
}