<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIREMU TNI') }}</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        overflow-x: hidden;
        background: #f8f9fa;
    }

    .sidebar {
        width: 220px; 
        height: 100vh;
        position: fixed;
        top: 56px;
        left: 0;
        background: #ffffff;
        box-shadow: 2px 0 10px rgba(0,0,0,0.06);
        padding-top: 1rem;
        border-radius: 0 10px 10px 0;
        z-index: 2000;
        transition: transform 0.25s ease, width 0.25s ease;
    }

    .sidebar.collapsed {
        transform: translateX(-95%); 
    }

    .sidebar .nav-link {
        color: #333;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 8px;
        margin: 4px 10px;
        transition: all 0.25s ease;
        position: relative;
    }

    .sidebar .nav-link:hover {
        background: #455de7;
        color: #fff;
        box-shadow: 0 3px 8px rgba(69, 93, 231, 0.3);
        transform: translateX(2px);
    }

    /* ===== Active Menu Highlight ===== */
    .sidebar .nav-link.active {
        background: #455de7;
        color: #fff !important;
        box-shadow: 0 4px 6px rgba(69, 93, 231, 0.4);
    }

    .sidebar .nav-link.active::before {
        content: "";
        position: absolute;
        left: -6px;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 60%;
        background: #0015ff;
        border-radius: 0 4px 4px 0;
    }

    /* ===== Overlay (Mobile) ===== */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 70%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        display: none;
        z-index: 1500;
        transition: opacity 0.3s ease;
    }

    .overlay.active {
        display: block;
    }

    /* ===== Content Area ===== */
    .content {
        margin-left: 230px;
        margin-top: 56px;
        padding: 20px;
        transition: margin-left 0.25s ease-in-out;
    }

    .content.expanded {
        margin-left: 0;
    }

    /* ===== Chart Container ===== */
    #chartContainer {
        transition: all 0.3s ease;
    }

    #tniChart {
        width: 100% !important;
        height: auto !important;
    }

    /* ===== Responsive (Mobile View) ===== */
    @media (max-width: 768px) {
        .sidebar {
            width: 70%;
            transform: translateX(-100%);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .content {
            margin-left: 0 !important;
        }

        #chartContainer {
            width: 100%;
        }
    }
</style>
</head>
<body>
<div id="app">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm fixed-top">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <button id="sidebarToggle" class="btn btn-light btn-sm">
                    <ion-icon id="toggleIcon" name="menu-outline" size="small"></ion-icon>
                </button>
                <img src="{{ asset('images/LOGOPUSINFO.png') }}" alt="Logo" style="height: 36px;">
                <span class="navbar-brand fw-bold text-white mb-0">SIREMU TNI</span>
            </div>

            <span id="datetime" class="text-white fw-semibold small d-none d-md-inline"></span>

            <ul class="navbar-nav ms-auto d-flex align-items-center">

                {{-- 🔔 NOTIFIKASI ADMIN --}}
                @if(Auth::user()->role === 'admin')
                <li class="nav-item dropdown me-2">
                    <a class="nav-link position-relative" href="#" id="notifDropdown" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <ion-icon name="notifications-outline" style="color:white;"></ion-icon>
                        @php $unreadCount = $notifications->where('is_read', false)->count(); @endphp
                        @if($unreadCount > 0)
                            <span id="notifCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notifDropdown" style="width: 300px; max-height: 400px; overflow-y: auto;">
                        <li class="dropdown-header fw-bold text-center">Notifikasi</li>
                        <div class="dropdown-divider"></div>

                        @forelse($notifications as $notif)
                            <li class="px-2 py-2 border-bottom small d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold {!! $notif->is_read ? 'text-muted' : '' !!}">
                                        {!! $notif->message !!}
                                    </div>
                                    <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                </div>
                                <button class="btn btn-sm btn-outline-danger ms-2 deleteNotif" data-id="{{ $notif->id }}">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </button>
                            </li>
                        @empty
                            <li class="text-center py-2 text-muted">Tidak ada notifikasi</li>
                        @endforelse

                        <div class="dropdown-divider"></div>
                        <li class="text-center">
                            <button id="clearReadNotif" class="btn btn-sm btn-danger">Hapus Semua</button>
                        </li>
                    </ul>
                </li>
                @endif

                <!-- USER DROPDOWN -->
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-white fw-bold p-0" href="#" role="button"
                       data-bs-toggle="dropdown">
                        {{ Str::limit(Auth::user()->name, 10) }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow">
                        <a class="dropdown-item" href="{{ route('admin.profil') }}">
                            <ion-icon name="person-circle-outline"></ion-icon> Profil
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <ion-icon name="log-out-outline"></ion-icon> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <ul class="nav flex-column px-2">
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}" id="manajemenLink">
                    <ion-icon name="list-outline"></ion-icon> Manajemen Data
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.monitoring') ? 'active' : '' }}" href="{{ route('admin.monitoring') }}"id="monitoringLink">
                    <ion-icon name="reader-outline"></ion-icon> Monitoring & Laporan
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.data') ? 'active' : '' }}" href="{{ route('admin.data') }}">
                    <ion-icon name="person-add-outline"></ion-icon> Data Admin
                </a>
            </li>
            <li class="nav-item mb-3">
                <div id="chartContainer" style="display:none; padding: 5px;">
                    <canvas id="tniChart" height="200"></canvas>
                </div>
            </li>
        </ul>
    </div>

    <div class="overlay d-md-none" id="overlay"></div>

    <main class="content" id="content">
        @yield('content')
    </main>
</div>

<!-- ====== DI BAGIAN BAWAH (script) ====== -->
<<script>
document.addEventListener("DOMContentLoaded", function () {
    // ======= Elemen Umum =======
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const toggleIcon = document.getElementById('toggleIcon');
    const overlay = document.getElementById('overlay');
    const datetimeEl = document.getElementById('datetime');
    const notifDropdown = document.getElementById('notifDropdown');
    const notifCount = document.getElementById('notifCount');
    const clearReadNotifBtn = document.getElementById('clearReadNotif');
    const chartContainer = document.getElementById('chartContainer');
    const manajemenLink = document.getElementById('manajemenLink');
    const monitoringLink = document.getElementById('monitoringLink');
    let tniChart = null;

    // ========== 🕒 Update Tanggal dan Waktu ==========
    function updateDateTime() {
        const now = new Date();
        const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        datetimeEl.textContent = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()} | ${now.toLocaleTimeString()}`;
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    sidebarToggle.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('active');
        } else {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');
        }

        toggleIcon.setAttribute('name',
            sidebar.classList.contains('collapsed') || !sidebar.classList.contains('show')
                ? 'menu-outline' : 'close-outline'
        );

        setTimeout(() => {
            if (tniChart) tniChart.resize();
        }, 350);
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('show');
        overlay.classList.remove('active');
        toggleIcon.setAttribute('name', 'menu-outline');
    });

    // ========== 🔔 Notifikasi ==========
    notifDropdown?.addEventListener('click', () => {
        fetch("{{ route('admin.notif.readAll') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content }
        }).then(res => res.json()).then(data => {
            if (data.success && notifCount) notifCount.remove();
        });
    });
    function loadChartData() {
        fetch("{{ route('admin.chartData') }}")
            .then(res => res.json())
            .then(data => {
                const ctx = document.getElementById('tniChart').getContext('2d');

                const date = new Date();
                const namaBulan = date.toLocaleString('id-ID', { month: 'long' });
                const tahun = date.getFullYear();
                const judulChart = `Jumlah Personel Bulan ${namaBulan} ${tahun}`;

                if (typeof tniChart !== 'undefined' && tniChart) {
                    tniChart.destroy();
                }
                const imgAD = new Image();
                const imgAL = new Image();
                const imgAU = new Image();

                imgAD.src = "{{ asset('images/TNIAD.png') }}";
                imgAL.src = "{{ asset('images/TNIAL1.png') }}";
                imgAU.src = "{{ asset('images/TNIAU.png') }}";
                Promise.all([
                    new Promise(resolve => { imgAD.onload = resolve; imgAD.onerror = resolve; }),
                    new Promise(resolve => { imgAL.onload = resolve; imgAL.onerror = resolve; }),
                    new Promise(resolve => { imgAU.onload = resolve; imgAU.onerror = resolve; })
                ]).then(() => {
                    tniChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['TNI AD', 'TNI AL', 'TNI AU'],
                            datasets: [{
                                label: 'Jumlah Personel Bulan Ini',
                                data: [data.ad, data.al, data.au],
                                backgroundColor: ['#145c32ff', '#787a7cff', '#39539cff'],
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    bottom: 60 
                                }
                            },
                            plugins: {
                                legend: { display: false },
                                title: {
                                    display: true,
                                    text: judulChart,
                                    font: { size: 14, weight: 'bold' },
                                    color: '#333'
                                },
                                datalabels: {
                                    color: '#000',
                                    anchor: 'end',
                                    align: 'start',
                                    font: { weight: 'bold', size: 12 },
                                    formatter: value => value
                                }
                            },
                            scales: {
                                x: {
                                    ticks: { display: false } 
                                },
                                y: {
                                    beginAtZero: true,
                                    ticks: { stepSize: 1 }
                                }
                            }
                        },
                        plugins: [
                            ChartDataLabels,
                            {
                                id: 'customImageLabels',
                                afterDraw: (chart) => {
                                    const { ctx, chartArea: { bottom }, scales: { x } } = chart;
                                    const images = [imgAD, imgAL, imgAU];
                                    const size = 45; 
                                    const offsetY = 20; 

                                    ctx.save();
                                    ctx.imageSmoothingEnabled = true; // pastikan smoothing aktif
                                    ctx.imageSmoothingQuality = 'high'; // kualitas tinggi
                                    x.ticks.forEach((tick, index) => {
                                        const xPos = x.getPixelForTick(index);
                                        if (images[index].complete) {
                                            ctx.drawImage(
                                                images[index],
                                                xPos - size / 2,
                                                bottom + offsetY,
                                                size,
                                                size
                                            );
                                        }
                                    });
                                    ctx.restore();
                                }
                            }
                        ]
                    });

                    const chartContainer = document.getElementById('chartContainer');
                    if (chartContainer) chartContainer.style.display = 'block';
                });
            })
            .catch(err => console.error('❌ Gagal memuat data chart:', err));
    }
    const currentPath = window.location.pathname;

    if (
        currentPath === '/admin' || 
        currentPath.includes('/admin/index') || 
        currentPath.includes('/admin/monitoring')
    ) {
        chartContainer.style.display = 'block';
        loadChartData();
    } else {
        chartContainer.style.display = 'none';
    }

    manajemenLink?.addEventListener('click', function () {
        chartContainer.style.display = 'block';
        loadChartData();
    });

    monitoringLink?.addEventListener('click', function () {
        chartContainer.style.display = 'block';
        loadChartData();
    });


    document.querySelectorAll('.deleteNotif').forEach(btn => {
        btn.addEventListener('click', function() {
            const notifId = this.dataset.id;
            Swal.fire({
                title: 'Hapus Notifikasi?',
                text: 'Apakah kamu yakin ingin menghapus notifikasi ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // 🔥 Jika dikonfirmasi, kirim request hapus
                    fetch(`/admin/notif/delete/${notifId}`, {
                        method: "DELETE",
                        headers: { 
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content 
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.closest('li').remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Notifikasi telah dihapus.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Notifikasi gagal dihapus. Coba lagi.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            text: 'Server tidak merespons.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    });
                }
            });
        });
    });


    clearReadNotifBtn?.addEventListener('click', () => {
        fetch("{{ route('admin.notif.clearRead') }}", {
            method: "DELETE",
            headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content }
        }).then(res => res.json())
        .then(data => {
            if (data.success) {
                document.querySelectorAll('.dropdown-menu li').forEach(li => {
                    if (li.querySelector('.text-muted')) li.remove();
                });
            }
        });
    });
    window.addEventListener('resize', () => {
        if (tniChart) tniChart.resize();
    });
});
</script>

</body>
</html>
