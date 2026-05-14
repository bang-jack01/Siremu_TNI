@extends('layouts.adminapp')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header text-white d-flex justify-content-between align-items-center flex-wrap py-3 px-4"style="background: linear-gradient(135deg, #0d6efd, #084298) !important;">
            <h5 class="mb-2 mb-sm-0 fw-semibold">SIREMU TNI — Data Prajurit</h5>

            <div class="d-flex align-items-center flex-wrap gap-2">
                <form action="{{ route('admin.index') }}" method="GET" 
                      class="d-flex align-items-center flex-nowrap gap-2"
                      onsubmit="return handleSearch(event)">
                    <input 
                        type="text" 
                        id="searchInput" 
                        name="search" 
                        class="form-control form-control-sm" 
                        placeholder="Cari NRP / KORP / NIK / Nama..." 
                        value="{{ request('search') }}"> 
                    <button type="submit" class="btn btn-light btn-sm">Cari</button>
                    <a href="{{ route('admin.index') }}" class="btn btn-outline-light btn-sm">Reset</a>
                </form>

                <!-- Tombol Tambah Data -->
                <a href="{{ route('admin.data.create') }}" 
                   class="btn btn-success btn-sm d-flex align-items-center gap-1">
                    <ion-icon name="person-add-outline"></ion-icon>
                    Tambah Data
                </a>
            </div>
        </div>

        <!-- Body -->
        <div class="card-body p-3 p-md-4">
            <form id="bulkDeleteForm" action="{{ route('admin.bulkDelete') }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-dark text-center">
                            <tr style="font-size: 0.9rem;">
                                <th style="width: 35px;"><input type="checkbox" id="selectAll"></th>
                                <th style="min-width: 130px;">Nama</th>
                                <th style="min-width: 90px;">NRP</th>
                                <th style="min-width: 90px;">KORP</th>
                                <th style="min-width: 120px;">NIK</th>
                                <th style="min-width: 110px;">Pangkat</th>
                                <th style="min-width: 100px;">Matra</th>
                                <th style="min-width: 100px;">Jenis Kelamin</th>
                                <th style="min-width: 140px;">Satuan Asal</th>
                                <th style="min-width: 140px;">Satuan Baru</th>
                                <th style="min-width: 120px;">No Kep</th>
                                <th style="min-width: 110px;">Tgl Kep</th>
                                <th style="min-width: 120px;">No Sprint</th>
                                <th style="min-width: 110px;">Tgl Sprint</th>
                                <th style="min-width: 220px;">Alamat</th> <!-- diperlebar -->
                                <th style="min-width: 120px;">No HP</th>
                                <th style="min-width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.88rem;">
                            @forelse($prajurit as $row)
                                <tr data-prajurit='@json($row)' style="cursor:pointer;">
                                    <td class="text-center">
                                        <input type="checkbox" name="ids[]" value="{{ $row->id }}" class="rowCheckbox">
                                    </td>
                                    <td onclick="showDetail(this.closest('tr'))" class="text-primary fw-semibold text-decoration-underline">
                                        {{ $row->name }}
                                    </td>
                                    <td>{{ $row->nrp }}</td>
                                    <td>{{ $row->korp }}</td>
                                    <td>{{ $row->nik }}</td>
                                    <td>{{ $row->pangkat }}</td>
                                    <td>{{ $row->angkatan }}</td>
                                    <td>{{ $row->gender }}</td>
                                    <td>{{ $row->satuan_asal }}</td>
                                    <td>{{ $row->satuan_baru }}</td>
                                    <td>{{ $row->no_kep }}</td>
                                    <td>{{ $row->tgl_kep }}</td>
                                    <td>{{ $row->no_sprin }}</td>
                                    <td>{{ $row->tgl_sprin }}</td>
                                    <td style="white-space: normal; max-width: 240px;">{{ $row->alamat }}</td>
                                    <td>{{ $row->no_hp }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.edit', $row->id) }}" 
                                           class="btn btn-sm btn-outline-warning"
                                           title="Edit Data"
                                           onclick="event.stopPropagation();">
                                           <ion-icon name="pencil-outline"></ion-icon>
                                        </a>
                                        <form action="{{ route('admin.destroy', $row->id) }}" 
                                              method="POST" 
                                              style="display:inline;"
                                              onsubmit="event.stopPropagation(); return confirm('Hapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Hapus Data">
                                                <ion-icon name="trash-outline"></ion-icon>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="16" class="text-center text-muted py-3">Tidak ada data ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Tombol hapus -->
                <div class="text-end mt-3">
                    <button type="button" id="deleteSelectedBtn" class="btn btn-danger btn-sm rounded-pill px-3" disabled>
                        <i class="bi bi-trash3 me-1"></i> Hapus Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .table th, .table td {
        padding: 0.1rem 0.7rem !important;
        vertical-align: middle;
    }

    .table thead th {
        white-space: nowrap;
    }

    .table-hover tbody tr:hover {
        background-color: #f2f6ff;
        transition: background-color 0.2s ease-in-out;
    }
    td[style*="white-space: normal;"] {
        word-wrap: break-word;
    }
</style>
<!-- Modal Detail Prajurit -->
<div id="detailCard" 
     class="d-none position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
     style="background:rgba(0,0,0,0.45); backdrop-filter: blur(3px); z-index:1055;"
     onclick="closeDetailOutside(event)">
    <div class="card shadow-lg border-0 rounded-4 animate__animated animate__fadeInDown" 
         style="max-width:380px; width:90%; max-height:80vh; overflow-y:auto;"
         onclick="event.stopPropagation()">

        <div class="card-header bg-gradient bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4 py-2">
            <h6 id="detailTitle" class="mb-0 fw-semibold">
                <i class="bi bi-person-badge me-2"></i>Detail Prajurit
            </h6>
            <button class="btn-close btn-close-white btn-sm" onclick="closeDetail()"></button>
        </div>

        <div class="card-body p-3">
            <div class="text-center mb-3">
                <img id="detailFoto" src="{{ asset('images/default-user.png') }}"
                     class="rounded-circle shadow-sm border border-light mb-2" width="90" height="90">
                <div>
                    <a id="downloadFotoBtn" href="{{ asset('images/default-user.png') }}" download
                       class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 shadow-sm">
                        <i class="bi bi-download me-1"></i>Download
                    </a>
                </div>
            </div>

            <div id="detailContent" class="row row-cols-2 g-2 small"></div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const selectAll = document.getElementById('selectAll');
const deleteBtn = document.getElementById('deleteSelectedBtn');
const form = document.getElementById('bulkDeleteForm');
function toggleDeleteButton() {
    const anyChecked = document.querySelectorAll('.rowCheckbox:checked').length > 0;
    deleteBtn.disabled = !anyChecked;
}

document.addEventListener('change', function(e) {
    if (e.target.matches('#selectAll')) {
        document.querySelectorAll('.rowCheckbox').forEach(cb => cb.checked = e.target.checked);
        toggleDeleteButton();
    }
    if (e.target.matches('.rowCheckbox')) {
        toggleDeleteButton();
    }
});

// konfirmasi hapus banyak
deleteBtn.addEventListener('click', (e) => {
    e.preventDefault();
    const selected = document.querySelectorAll('.rowCheckbox:checked');
    if (selected.length === 0) return;

    Swal.fire({
        title: 'Yakin hapus data?',
        text: `${selected.length} data prajurit akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d'
    }).then(result => {
        if (result.isConfirmed) form.submit();
    });
});

// ======== Detail Card ========
function showDetail(el) {
    const data = JSON.parse(el.dataset.prajurit);
    const fotoUrl = data.foto ? `/storage/${data.foto}` : "{{ asset('images/default-user.png') }}";

    document.getElementById('detailFoto').src = fotoUrl;
    document.getElementById('downloadFotoBtn').href = fotoUrl;
    document.getElementById('detailTitle').innerText = "Detail - " + data.name;

    const fields = [
        ["Nama", data.name],
        ["Gender", data.gender],
        ["NRP", data.nrp],
        ["KORP", data.korp],
        ["NIK", data.nik],
        ["No HP", data.no_hp],
        ["Pangkat", data.pangkat],
        ["Mitra", data.angkatan],
        ["Sat Asal", data.satuan_asal],
        ["Sat Baru", data.satuan_baru],
        ["No Kep", data.no_kep],
        ["Tgl Kep", data.tgl_kep],
        ["No Sprint", data.no_sprin],
        ["Tgl Sprint", data.tgl_sprin],
    ];

    document.getElementById('detailContent').innerHTML = fields.map(([label, value]) => `
        <div class="col">
            <div class="border rounded-3 bg-light p-2 shadow-sm text-truncate small">
                <strong>${label}:</strong><br>${value || '-'}
            </div>
        </div>
    `).join('') + `
        <div class="col-12">
            <div class="border rounded-3 bg-light p-2 shadow-sm small">
                <strong>Alamat:</strong><br>${data.alamat || '-'}
            </div>
        </div>`;

    document.getElementById('detailCard').classList.remove('d-none');
}

function closeDetail() {
    document.getElementById('detailCard').classList.add('d-none');
}

function closeDetailOutside(e) {
    if (!document.querySelector('#detailCard .card').contains(e.target)) closeDetail();
}

function handleSearch(e) {
    e.preventDefault();
    const keyword = document.getElementById('searchInput').value.trim().toLowerCase();
    const rows = document.querySelectorAll("tbody tr[data-prajurit]");
    let matches = [];

    if (keyword === "") {
        rows.forEach(r => r.classList.remove("d-none", "table-info"));
        return false;
    }

    rows.forEach(row => {
        const data = JSON.parse(row.dataset.prajurit);
        const cocok =
            data.name.toLowerCase().includes(keyword) ||
            data.nrp.toLowerCase().includes(keyword) ||
            data.korp.toLowerCase().includes(keyword) ||
            data.nik.toLowerCase().includes(keyword);

        if (cocok) {
            row.classList.remove("d-none");
            row.classList.add("table-info");
            matches.push(row);
        } else {
            row.classList.add("d-none");
            row.classList.remove("table-info");
        }
    });

    if (matches.length === 0) {
        Swal.fire({
            icon: 'info',
            title: 'Tidak ada data ditemukan',
            text: 'Coba kata kunci lain ya.',
            confirmButtonColor: '#3085d6'
        });
        return false;
    }
    if (matches.length === 1) {
        showDetail(matches[0]);
        return false;
    }


    Swal.fire({
        icon: 'success',
        title: 'Ditemukan ' + matches.length + ' data',
        text: 'Menampilkan semua hasil yang cocok di tabel.',
        timer: 1800,
        showConfirmButton: false
    });

    return false; 
}

</script>
@endsection
