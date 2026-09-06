<!DOCTYPE html>
<html lang="id" :class="{ 'dark': modeGelap }" x-data="{ modeGelap: localStorage.getItem('tema') === 'gelap' || (!localStorage.getItem('tema') && window.matchMedia('(prefers-color-scheme: dark)').matches), menuTerbuka: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $identitas->nama_aplikasi ?? 'Media Learning & Plan Hub' }}</title>
    <!-- Google Font: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    borderRadius: {
                        '4xl': '2rem',
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js, SweetAlert2 & Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { font-family: 'Poppins', sans-serif !important; }
        .soft-card {
            box-shadow: 0 10px 30px -5px rgba(67, 97, 238, 0.08);
            border-radius: 1.75rem;
        }
        .dark .soft-card {
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.35);
        }
        .edu-badge {
            border-radius: 9999px;
            padding: 0.25rem 0.85rem;
            font-weight: 700;
            font-size: 0.725rem;
        }
        .playful-btn {
            border-radius: 1.25rem;
            transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .playful-btn:hover {
            transform: translateY(-2px);
        }
        .playful-btn:active {
            transform: translateY(1px);
        }

        /* Versi Mobile: Button & CTA Memanjang Selebar Parent */
        @media (max-width: 639px) {
            .mobile-full,
            .playful-btn,
            button:not(.w-11):not(.w-9):not(.w-8):not(.w-7):not(.inline *),
            input[type="submit"] {
                width: 100% !important;
                justify-content: center !important;
                text-align: center !important;
            }
            .btn-mobile-full {
                width: 100% !important;
            }
        }
    </style>
</head>
<body class="bg-[#f8f9fe] text-slate-800 dark:bg-[#0f111a] dark:text-slate-100 min-h-screen transition-colors duration-300 flex flex-col antialiased selection:bg-indigo-500 selection:text-white relative">

    <!-- Soft Ambient Playful Bubbles -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10 opacity-60 dark:opacity-20">
        <div class="absolute -top-32 right-10 w-96 h-96 bg-indigo-200 rounded-full blur-[100px]"></div>
        <div class="absolute top-1/3 -left-20 w-80 h-80 bg-rose-200 rounded-full blur-[90px]"></div>
        <div class="absolute -bottom-20 right-1/4 w-80 h-80 bg-amber-100 rounded-full blur-[90px]"></div>
    </div>

    <!-- Soft Modern Header -->
    <header class="border-b border-slate-200/70 dark:border-slate-800/80 bg-white/80 dark:bg-[#151824]/80 backdrop-blur-xl sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('beranda') }}" class="flex items-center gap-3.5 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-500 via-indigo-600 to-purple-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 group-hover:rotate-6 transition duration-300 shrink-0">
                    <i data-lucide="sparkles" class="w-6 h-6"></i>
                </div>
                <div>
                    <span class="font-extrabold text-lg text-slate-800 dark:text-white tracking-tight block">{{ $identitas->nama_aplikasi ?? 'Media Plan Hub' }}</span>
                    <span class="text-[10px] uppercase font-bold tracking-widest text-indigo-500 dark:text-indigo-400 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Sistem Perencanaan Media
                    </span>
                </div>
            </a>

            <!-- Right Controls -->
            <div class="flex items-center gap-2.5 sm:gap-3">
                <!-- Theme Toggle Button -->
                <button 
                    @click="modeGelap = !modeGelap; localStorage.setItem('tema', modeGelap ? 'gelap' : 'terang')"
                    class="w-11 h-11 rounded-2xl bg-slate-100 dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center hover:scale-105 transition"
                    title="Ubah Mode">
                    <span x-show="!modeGelap" class="flex items-center justify-center"><i data-lucide="moon" class="w-5 h-5"></i></span>
                    <span x-show="modeGelap" class="flex items-center justify-center"><i data-lucide="sun" class="w-5 h-5 text-amber-400"></i></span>
                </button>

                <!-- Desktop Action Buttons -->
                <div class="hidden sm:flex items-center gap-3">
                    @if(auth('admin')->check())
                        <a href="{{ route('admin.dasbor') }}" class="text-xs font-bold px-4 py-2.5 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800/60 hover:bg-indigo-100 transition">Dasbor Admin</a>
                        <form action="{{ route('keluar') }}" method="POST" class="inline">
                            @csrf
                            <button type="button" onclick="konfirmasiKeluar(event)" class="text-xs px-4 py-2.5 rounded-2xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 hover:bg-rose-100 font-bold border border-rose-200/60 dark:border-rose-800/40 transition">Keluar</button>
                        </form>
                    @elseif(auth('operator')->check())
                        <a href="{{ route('operator.dasbor') }}" class="text-xs font-bold px-4 py-2.5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-800/60 hover:bg-emerald-100 transition">Dasbor Operator</a>
                        <form action="{{ route('keluar') }}" method="POST" class="inline">
                            @csrf
                            <button type="button" onclick="konfirmasiKeluar(event)" class="text-xs px-4 py-2.5 rounded-2xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 hover:bg-rose-100 font-bold border border-rose-200/60 dark:border-rose-800/40 transition">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('masuk') }}" class="text-xs font-bold px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-500/25 playful-btn">
                            Masuk
                        </a>
                    @endif
                </div>

                <!-- Tombol Garis 3 Mobile -->
                <button 
                    @click="menuTerbuka = true"
                    type="button"
                    class="sm:hidden w-11 h-11 rounded-2xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 flex items-center justify-center focus:outline-none transition active:scale-90"
                    aria-label="Buka Sidebar">
                    <div class="w-5 h-5 flex flex-col justify-center items-center gap-1">
                        <span class="w-5 h-0.5 bg-current rounded-full"></span>
                        <span class="w-5 h-0.5 bg-current rounded-full"></span>
                        <span class="w-5 h-0.5 bg-current rounded-full"></span>
                    </div>
                </button>
            </div>
        </div>
    </header>

    <!-- Backdrop Gelap Mobile saat Sidebar Terbuka -->
    <div 
        x-show="menuTerbuka" 
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="menuTerbuka = false"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 sm:hidden"
        style="display: none;">
    </div>

    <!-- SIDEBAR MOBILE (MUNCUL DARI SAMPING KANAN) -->
    <aside 
        x-show="menuTerbuka"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 w-4/5 max-w-sm bg-white dark:bg-[#151824] shadow-2xl z-50 p-6 flex flex-col justify-between sm:hidden overflow-y-auto"
        style="display: none;">

        <div>
            <!-- Header Sidebar Mobile -->
            <div class="flex items-center justify-between pb-6 border-b border-slate-100 dark:border-slate-800 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shadow-md shadow-indigo-500/30">
                        <i data-lucide="compass" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-sm text-slate-800 dark:text-white leading-tight">Navigasi Media</h4>
                        <span class="text-[10px] text-indigo-500 font-bold">Sistem Perencanaan Media</span>
                    </div>
                </div>
                <!-- Tombol Tutup Sidebar -->
                <button 
                    @click="menuTerbuka = false" 
                    type="button"
                    class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 flex items-center justify-center transition">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Tautan Navigasi Samping -->
            <div class="space-y-2 text-xs font-bold">
                <a href="{{ route('beranda') }}" @click="menuTerbuka = false" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-slate-100/80 dark:bg-slate-800/60 text-slate-800 dark:text-slate-200 hover:bg-indigo-50 hover:text-indigo-600 transition">
                    <i data-lucide="home" class="w-4 h-4 text-indigo-500"></i> Beranda Utama
                </a>

                @if(auth('admin')->check())
                    <div class="p-4 rounded-3xl bg-indigo-50/80 dark:bg-indigo-950/40 border border-indigo-100 dark:border-indigo-900/60 my-4">
                        <span class="font-black text-indigo-600 dark:text-indigo-400 block text-xs">{{ auth('admin')->user()->nama }}</span>
                        <span class="text-[10px] text-slate-400 font-medium">Administrator Utama</span>
                    </div>

                    <a href="{{ route('admin.dasbor') }}" @click="menuTerbuka = false" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-indigo-600 text-white font-extrabold shadow-md shadow-indigo-500/25">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dasbor Admin
                    </a>
                    <a href="{{ route('admin.identitas') }}" @click="menuTerbuka = false" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-800 hover:text-indigo-600 transition">
                        <i data-lucide="sliders" class="w-4 h-4 text-slate-400"></i> Identitas Web
                    </a>
                    <a href="{{ route('admin.operator') }}" @click="menuTerbuka = false" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-800 hover:text-indigo-600 transition">
                        <i data-lucide="users" class="w-4 h-4 text-slate-400"></i> Kelola Operator
                    </a>
                @elseif(auth('operator')->check())
                    <div class="p-4 rounded-3xl bg-emerald-50/80 dark:bg-emerald-950/40 border border-emerald-100 dark:border-emerald-900/60 my-4">
                        <span class="font-black text-emerald-600 dark:text-emerald-400 block text-xs">{{ auth('operator')->user()->nama }}</span>
                        <span class="text-[10px] text-slate-400 font-medium">Operator Media</span>
                    </div>

                    <a href="{{ route('operator.dasbor') }}" @click="menuTerbuka = false" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('operator.dasbor') ? 'bg-emerald-500 text-white font-extrabold shadow-md shadow-emerald-500/25' : 'text-slate-700 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-600 transition' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 {{ request()->routeIs('operator.dasbor') ? '' : 'text-slate-400' }}"></i> Dashboard
                    </a>
                    <a href="{{ route('operator.proyek') }}" @click="menuTerbuka = false" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('operator.proyek') ? 'bg-emerald-500 text-white font-extrabold shadow-md shadow-emerald-500/25' : 'text-slate-700 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-600 transition' }}">
                        <i data-lucide="clapperboard" class="w-4 h-4 {{ request()->routeIs('operator.proyek') ? '' : 'text-slate-400' }}"></i> Proyek Media
                    </a>
                    <a href="{{ route('operator.lokasi') }}" @click="menuTerbuka = false" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('operator.lokasi') ? 'bg-emerald-500 text-white font-extrabold shadow-md shadow-emerald-500/25' : 'text-slate-700 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-600 transition' }}">
                        <i data-lucide="globe" class="w-4 h-4 {{ request()->routeIs('operator.lokasi') ? '' : 'text-slate-400' }}"></i> Kanal Unggahan
                    </a>
                @else
                    <div class="pt-4">
                        <a href="{{ route('masuk') }}" @click="menuTerbuka = false" class="flex items-center justify-center gap-2 text-xs font-bold px-4 py-3.5 rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-500/25 playful-btn">
                            <i data-lucide="log-in" class="w-4 h-4"></i> Masuk ke Sistem
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer Sidebar Mobile -->
        @if(auth('admin')->check() || auth('operator')->check())
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
                <form action="{{ route('keluar') }}" method="POST">
                    @csrf
                    <button type="button" onclick="konfirmasiKeluar(event)" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-2xl bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 font-bold text-xs transition">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar Sistem
                    </button>
                </form>
            </div>
        @endif
    </aside>

    <!-- Content -->
    <main class="flex-1 w-full">
        @yield('konten')
    </main>

    <!-- Playful Footer (Hanya untuk Tamu / Publik) -->
    @if(!auth('admin')->check() && !auth('operator')->check())
    <footer class="border-t border-slate-200/80 dark:border-slate-800/80 py-8 text-center text-xs text-slate-500 dark:text-slate-400 bg-white/60 dark:bg-[#151824]/60 px-4">
        <p class="font-medium tracking-wide">{{ $identitas->teks_footer ?? '© 2026 Media Plan Hub. Hak cipta dilindungi.' }}</p>
    </footer>
    @endif

    <!-- SweetAlert Global Configuration & Helpers -->
    <script>
        function konfirmasiHapus(event, judul = 'Apakah Anda yakin?', teks = 'Data yang dihapus tidak dapat dipulihkan!') {
            event.preventDefault();
            const form = event.target.closest('form');
            const isDark = document.documentElement.classList.contains('dark');

            Swal.fire({
                title: judul,
                text: teks,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Sekarang!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                background: isDark ? '#151824' : '#ffffff',
                color: isDark ? '#f8fafc' : '#1e293b',
                customClass: {
                    popup: 'rounded-4xl border border-slate-200/80 dark:border-slate-800 shadow-2xl p-6',
                    confirmButton: 'rounded-2xl px-5 py-3 font-bold text-xs',
                    cancelButton: 'rounded-2xl px-5 py-3 font-bold text-xs'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        function konfirmasiKeluar(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            const isDark = document.documentElement.classList.contains('dark');

            Swal.fire({
                title: 'Ingin Keluar Sistem?',
                text: 'Sesi Anda saat ini akan diakhiri.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Tetap di Sini',
                reverseButtons: true,
                background: isDark ? '#151824' : '#ffffff',
                color: isDark ? '#f8fafc' : '#1e293b',
                customClass: {
                    popup: 'rounded-4xl border border-slate-200/80 dark:border-slate-800 shadow-2xl p-6',
                    confirmButton: 'rounded-2xl px-5 py-3 font-bold text-xs',
                    cancelButton: 'rounded-2xl px-5 py-3 font-bold text-xs'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

    @if(session('sukses'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const isDark = document.documentElement.classList.contains('dark');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('sukses') }}',
                    timer: 3000,
                    showConfirmButton: false,
                    background: isDark ? '#151824' : '#ffffff',
                    color: isDark ? '#f8fafc' : '#1e293b',
                    customClass: {
                        popup: 'rounded-4xl border border-emerald-500/20 shadow-2xl p-6'
                    }
                });
            });
        </script>
    @endif

    @if(session('galat'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const isDark = document.documentElement.classList.contains('dark');
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: '{{ session('galat') }}',
                    background: isDark ? '#151824' : '#ffffff',
                    color: isDark ? '#f8fafc' : '#1e293b',
                    customClass: {
                        popup: 'rounded-4xl border border-rose-500/20 shadow-2xl p-6'
                    }
                });
            });
        </script>
    @endif

    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const isDark = document.documentElement.classList.contains('dark');
                Swal.fire({
                    icon: 'warning',
                    title: 'Periksa Kembali Input Anda',
                    html: '<ul class="text-left text-xs space-y-1 mt-2">@foreach($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>',
                    confirmButtonText: 'Dimengerti',
                    confirmButtonColor: '#6366f1',
                    background: isDark ? '#151824' : '#ffffff',
                    color: isDark ? '#f8fafc' : '#1e293b',
                    customClass: {
                        popup: 'rounded-4xl border border-amber-500/20 shadow-2xl p-6',
                        confirmButton: 'rounded-2xl px-5 py-3 font-bold text-xs'
                    }
                });
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
        document.addEventListener('alpine:initialized', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
