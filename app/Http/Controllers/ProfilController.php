<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function admin()
    {
        return view('admin.profil', [
            'user' => Auth::user()
        ]);
    }
    public function client()
    {
        return view('client.profil', [
            'user' => Auth::user()
        ]);
    }
    public function showResetPasswordForm($id)
    {
        $user = User::findOrFail($id);
        return view('admin.reset-password', compact('user'));
    }
    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $user->email = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $namaAdmin = preg_replace('/[^A-Za-z0-9_\-]/', '_', Auth::user()->name);
            $filename = strtolower($namaAdmin) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/image', $filename);
            $user->foto = 'image/' . $filename;
        }
        $user->save();
        return redirect()->route('admin.index')->with('success', 'Profil admin berhasil diperbarui!');
    }
    
}
