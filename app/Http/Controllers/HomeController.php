<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prajurit;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('client.dashboard');
    }
    public function input()
    {
        return view('client.input');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:100',
            'satuan'        => 'required|string|max:100',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'no_ktp'        => 'nullable|string|max:50',
            'no_sprin'      => 'nullable|string|max:50',
            'nik'           => 'required|string|max:50|unique:prajurit,nik',
            'alamat'        => 'required|string|max:255',
            'pangkat'       => 'required|string|max:50',
            'no_hp'         => 'required|string|max:20',
            'satuan_asal'   => 'required|string|max:100',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan foto jika ada
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_prajurit', 'public');
            $validated['foto'] = $path;
        }

        Prajurit::create($validated);

        return redirect()->route('dashboard')->with('success', 'Data prajurit berhasil disimpan!');
    }
}
