<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function markAllRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        $notif = Notification::find($id);
        if ($notif) {
            $notif->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    public function clearRead()
    {
        try {
            // Mengosongkan seluruh isi tabel notifikasi
            Notification::truncate(); 

            // Mengembalikan respons sukses dalam format JSON untuk AJAX
            return response()->json([
                'success' => true,
                'message' => 'Semua notifikasi berhasil dibersihkan!'
            ], 200);
            
        } catch (\Exception $e) {
            // Mengembalikan respons gagal jika terjadi error pada database
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus notifikasi: ' . $e->getMessage()
            ], 500);
        }
    }
}
