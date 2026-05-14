<?php

namespace App\Http\Controllers;

use App\Models\Prajurit;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrajuritController extends Controller
{
    private $pangkats = [
        'AD' => ['Prajurit Dua','Prajurit Satu','Prajurit Kepala','Kopral Dua','Kopral Satu','Kopral Kepala','Sersan Dua','Sersan Satu','Sersan Kepala','Sersan Mayor','Pelda','Peltu','Letnan Dua','Letnan Satu','Kapten','Mayor','Letnan Kolonel','Kolonel','Brigadir Jenderal','Mayor Jenderal','Letnan Jenderal','Jenderal'],
        'AL' => ['Kelasi Dua','Kelasi Satu','Kelasi Kepala','Kopral Dua','Kopral Satu','Kopral Kepala','Sersan Dua','Sersan Satu','Sersan Kepala','Sersan Mayor','Pelda','Peltu','Letnan Dua','Letnan Satu','Kapten','Mayor','Letnan Kolonel','Kolonel','Laksamana Pertama','Laksamana Muda','Laksamana Madya','Laksamana'],
        'AU' => ['Prajurit Dua','Prajurit Satu','Prajurit Kepala','Kopral Dua','Kopral Satu','Kopral Kepala','Sersan Dua','Sersan Satu','Sersan Kepala','Sersan Mayor','Pelda','Peltu','Letnan Dua','Letnan Satu','Kapten','Mayor','Letnan Kolonel','Kolonel','Marsekal Pertama','Marsekal Muda','Marsekal Madya','Marsekal'],
    ];

    public function create()
    {
        return view('client.input', [
            'pangkats' => $this->pangkats,
            'prajurit' => new Prajurit()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100',
            'gender'        => 'required|in:Laki-laki,Perempuan',
            'nrp'           => 'required|string|max:16',
            'korp'          => 'required|string|max:16',
            'satuan_asal'   => 'required|string|max:100',
            'satuan_baru'   => 'required|string|max:100',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'no_kep'        => 'nullable|string|max:50',
            'tgl_kep'       => 'nullable|date',
            'no_sprin'      => 'nullable|string|max:50',
            'tgl_sprin'     => 'nullable|date',
            'nik'           => 'required|string|max:50|unique:prajurit,nik',
            'alamat'        => 'required|string|max:255',
            'pangkat'       => 'required|string',
            'no_hp'         => 'required|string|max:20',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if (strpos($request->pangkat, '|') === false) {
            return back()->withInput()->withErrors(['pangkat' => 'Format pangkat tidak valid!']);
        }

        [$angkatan, $pangkat] = explode('|', $request->pangkat);

        if (!isset($this->pangkats[$angkatan]) || !in_array($pangkat, $this->pangkats[$angkatan])) {
            return back()->withInput()->withErrors(['pangkat' => 'Pangkat tidak sesuai angkatan!']);
        }

        $validated['angkatan'] = $angkatan;
        $validated['pangkat'] = $pangkat;
        $validated['user_id'] = Auth::id();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/image', $filename);
            $validated['foto'] = 'image/' . $filename;
        }
        $prajurit = Prajurit::create($validated);
        Notification::create([
            'message' => 'Prajurit baru bernama ' . $prajurit->name . ' telah menambahkan data pada ' . now()->format('d M Y H:i'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Data prajurit berhasil disimpan!');
    }



    public function edit($id)
    {
        $prajurit = Prajurit::findOrFail($id);
        return view('client.update', [
            'prajurit' => $prajurit,
            'pangkats' => $this->pangkats
        ]);
    }

    public function update(Request $request, $id)
    {
        $prajurit = Prajurit::findOrFail($id);

        $validated = $request->validate([
            'pangkat'       => 'required|string',
            'no_kep'        => 'nullable|string|max:50',
            'tgl_kep'       => 'nullable|date',
            'satuan_baru'   => 'required|string|max:100',
            'no_sprin'      => 'nullable|string|max:50',
            'tgl_sprin'     => 'nullable|date',
            'alamat'        => 'required|string|max:255',
            'no_hp'         => 'required|string|max:20',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if (strpos($request->pangkat, '|') === false) {
            return back()->withInput()->withErrors(['pangkat' => 'Format pangkat tidak valid!']);
        }

        [$angkatan, $pangkat] = explode('|', $request->pangkat);

        if (!isset($this->pangkats[$angkatan]) || !in_array($pangkat, $this->pangkats[$angkatan])) {
            return back()->withInput()->withErrors(['pangkat' => 'Pangkat tidak sesuai angkatan!']);
        }

        $validated['angkatan'] = $angkatan;
        $validated['pangkat']  = $pangkat;        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/image', $filename);
            $validated['foto'] = 'image/' . $filename;
        }

        $prajurit->update($validated);
         Notification::create([
            'message' => 'Prajurit baru mengupdate data ' . $prajurit->name . ' telah menambahkan data pada ' . now()->format('d M Y H:i'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Data prajurit berhasil diperbarui!');
    }
}
