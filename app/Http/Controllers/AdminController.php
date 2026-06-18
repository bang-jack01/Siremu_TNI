<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prajurit;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Exports\PrajuritExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    private $pangkats = [
        'AD' => ['Pratu','Praka','Kopral','Sersan','Letnan Dua','Letnan Satu','Kapten','Mayor','Letnan Kolonel','Kolonel','Brigadir Jenderal','Mayor Jenderal','Letnan Jenderal','Jenderal'],
        'AL' => ['Kelasi','Kopral','Sersan','Letnan Dua','Letnan Satu','Kapten','Mayor','Letnan Kolonel','Kolonel','Laksamana Pertama','Laksamana Muda','Laksamana Madya','Laksamana'],
        'AU' => ['Pradet','Kopral','Sersan','Letnan Dua','Letnan Satu','Kapten','Mayor','Letnan Kolonel','Kolonel','Marsekal Pertama','Marsekal Muda','Marsekal Madya','Marsekal']
    ];

   public function index()
    {
        $admins = User::where('role', 'admin')->get();
        $prajurit = Prajurit::orderBy('created_at', 'desc')->get();
        $notifications = \App\Models\Notification::latest()->take(10)->get();
        return view('admin.index', compact('prajurit', 'admins', 'notifications'));
    }
    
    // ---------------------------
    // CRUD PRAJURIT
    // ---------------------------
    
    public function createData()
    {
        return view('admin.create-data', [
            'pangkats' => $this->pangkats,
            'prajurit' => new Prajurit()
        ]);
    }
    public function storeData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'gender'        => 'required|in:Laki-laki,Perempuan',
            'pangkat'       => 'required|string',               
            'nrp'           => 'required|string|max:16',
            'korp'          => 'required|string|max:3',
            'nik'           => 'required|string|max:16|unique:prajurit,nik',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'no_hp'         => 'required|string|max:20',
            'alamat'        => 'required|string',
            'no_kep'        => 'nullable|string|max:20',
            'tgl_kep'       => 'nullable|date',
            'no_sprin'      => 'nullable|string|max:20', 
            'tgl_sprin'     => 'nullable|date',
            'satuan_asal'   => 'required|string|max:20',
            'satuan_baru'   => 'required|string|max:20',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.data.create')
                             ->withErrors($validator)
                             ->withInput();
        }

        $data = $validator->validated();
        if (strpos($data['pangkat'], '|') !== false) {
            [$angkatan, $pangkat] = explode('|', $data['pangkat'], 2);
            $data['angkatan'] = $angkatan;
            $data['pangkat']  = $pangkat;
        } else {
            $data['angkatan'] = null;
        }

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('prajurit', 'public');
            $data['foto'] = $path; 
        }
        Prajurit::create($data);

        return redirect()->route('admin.index')->with('success', 'Data prajurit berhasil ditambahkan.');
       
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids) {
            Prajurit::whereIn('id', $ids)->delete();
        }
        return redirect()->route('admin.index')->with('success', 'Data terpilih berhasil dihapus.');
    }
    

    public function edit($id)
    {
        $prajurit = Prajurit::findOrFail($id);
        return view('admin.edit', compact('prajurit'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name'          => 'required|string|max:255',
            'pangkat'       => 'required|string|max:20',               
            'nrp'           => 'required|string|max:16',
            'korp'          => 'required|string|max:3',
            'nik'           => 'required|string|max:16',
            'gender'        => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'no_hp'         => 'required|string|max:20',
            'satuan_asal'   => 'required|string|max:20',
            'satuan_baru'   => 'required|string|max:20',
            'no_kep'        => 'nullable|string|max:20',
            'tgl_kep'       => 'nullable|date',
            'no_sprin'      => 'nullable|string|max:20', 
            'tgl_sprin'     => 'nullable|date',
            'alamat'        => 'required|string|max:120',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $prajurit = Prajurit::findOrFail($id);
        $data = $request->only([
            'name', 'pangkat', 'nrp', 'korp', 'nik', 'gender', 'no_hp',
            'satuan_asal', 'satuan_baru', 'no_kep', 'tgl_kep',
            'no_sprin', 'tgl_sprin', 'alamat','tempat_lahir','tanggal_lahir'
        ]);
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/foto_prajurit', $filename);
            if ($prajurit->foto) { Storage::delete('public/' . $prajurit->foto);
            }

            $data['foto'] = 'foto_prajurit/' . $filename;
        }
        $prajurit->update($data);

        return redirect()->route('admin.index')->with('success', 'Data prajurit berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $prajurit = Prajurit::findOrFail($id);
        $prajurit->delete();

        return redirect()->route('admin.index')->with('success', 'Data prajurit berhasil dihapus.');
    }

    
    // MONITORING & EXPORT
    // ---------------------------
    public function monitoring(Request $request)
{
    $filter = $request->get('filter', '1bulan');
    $angkatan = $request->get('angkatan', '');

    // Gunakan model Prajurit
    $query = Prajurit::query();

    // 🔹 Filter waktu
    if ($filter == '1bulan') {
        $query->where('created_at', '>=', Carbon::now()->subMonth());
    } elseif ($filter == '3bulan') {
        $query->where('created_at', '>=', Carbon::now()->subMonths(3));
    } elseif ($filter == '1tahun') {
        $query->where('created_at', '>=', Carbon::now()->subYear());
    }

    // 🔹 Filter angkatan (AD, AL, AU)
    if (!empty($angkatan)) {
        $query->where('angkatan', $angkatan);
    }

    $data = $query->orderBy('created_at', 'desc')->get();

    // 🔹 Hitung jumlah berdasarkan filter waktu
    $baseQuery = Prajurit::query();
    if ($filter == '1bulan') {
        $baseQuery->where('created_at', '>=', Carbon::now()->subMonth());
    } elseif ($filter == '3bulan') {
        $baseQuery->where('created_at', '>=', Carbon::now()->subMonths(3));
    } elseif ($filter == '1tahun') {
        $baseQuery->where('created_at', '>=', Carbon::now()->subYear());
    }

    $countAD = (clone $baseQuery)->where('angkatan', 'AD')->count();
    $countAL = (clone $baseQuery)->where('angkatan', 'AL')->count();
    $countAU = (clone $baseQuery)->where('angkatan', 'AU')->count();

    return view('admin.monitoring', compact(
        'data',
        'filter',
        'angkatan',
        'countAD',
        'countAL',
        'countAU'
    ));
}


    public function exportExcel(Request $request)
    {
        $filter   = $request->get('filter', '1bulan');
        $angkatan = $request->get('angkatan', '');

        if ($filter === '1bulan') {
            $periode = '1 Bulan Terakhir';
        } elseif ($filter === '3bulan') {
            $periode = '3 Bulan Terakhir';
        } elseif ($filter === '1tahun') {
            $periode = '1 Tahun Terakhir';
        } else {
            $periode = 'Semua Data';
        }

        return Excel::download(new PrajuritExport($filter, $angkatan, $periode), 'laporan_prajurit.xlsx');
    }

    // ---------------------------
    // ADMIN MANAGEMENT
    // ---------------------------
    public function adminList()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.user.index', compact('admins'));
    }

    public function data()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.data', compact('admins'));
    }

    public function createAdmin()
    {
        return view('admin.create');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function create()
    {
        return $this->createAdmin();
    }

    public function store(Request $request)
    {
        return $this->storeAdmin($request);
    }
    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->email = $request->email;

       if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = $file->hashName(); 
            $file->storeAs('public/profile', $filename);
            $user->foto = 'profile/' . $filename;
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('admin.index')->with('success', 'Profil berhasil diperbarui.');
    }
    
    public function getChartData()
    {
        $currentMonth = now()->month;
    
        $ad = Prajurit::where('angkatan', 'AD')->whereMonth('created_at', $currentMonth)->count();
        $al = Prajurit::where('angkatan', 'AL')->whereMonth('created_at', $currentMonth)->count();
        $au = Prajurit::where('angkatan', 'AU')->whereMonth('created_at', $currentMonth)->count();
    
        return response()->json([
            'ad' => $ad,
            'al' => $al,
            'au' => $au,
        ]);
    }
}
