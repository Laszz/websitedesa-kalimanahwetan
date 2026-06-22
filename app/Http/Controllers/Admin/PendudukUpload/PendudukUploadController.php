<?php

namespace App\Http\Controllers\Admin\PendudukUpload;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\PendudukUpload;
use App\Models\PendudukRequest;

class PendudukUploadController extends Controller
{
    // ===============================
    // LIST UPLOAD BERDASARKAN PERMOHONAN
    // ===============================
    public function index($requestId)
    {
        $requestData = PendudukRequest::findOrFail($requestId);

        $uploads = PendudukUpload::with('requirement')
            ->where('request_id', $requestId)
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.penduduk.uploads.index', compact('uploads', 'requestData'));
    }

    // ===============================
    // DOWNLOAD BERKAS
    // ===============================
    public function download($id)
    {
        $upload = PendudukUpload::findOrFail($id);

        if (empty($upload->file_path) || !Storage::disk('public')->exists($upload->file_path)) {
            abort(404, 'File tidak ditemukan atau rusak.');
        }

        return Storage::disk('public')->download($upload->file_path);
    }

        // ===============================
        // VIEW BERKAS (PREVIEW)
        // ===============================
        public function view($id)
        {
            $upload = PendudukUpload::findOrFail($id);

            if (empty($upload->file_path) || !Storage::disk('public')->exists($upload->file_path)) {
                abort(404, 'File tidak ditemukan atau rusak.');
            }

            return response()->file(
                storage_path('app/public/' . $upload->file_path)
            );
        }

    // ===============================
    // HAPUS FILE
    // ===============================
    public function destroy($id)
    {
        $upload = PendudukUpload::findOrFail($id);

        if (!empty($upload->file_path) && Storage::disk('public')->exists($upload->file_path)) {
            Storage::disk('public')->delete($upload->file_path);
        }

        $upload->delete();

        return back()->with('success', 'File upload berhasil dihapus!');
    }
}