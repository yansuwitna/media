<!DOCTYPE html>
<html lang="id" :class="{ 'dark': modeGelap }" x-data="{ modeGelap: localStorage.getItem('tema') === 'gelap' || (!localStorage.getItem('tema') && window.matchMedia('(prefers-color-scheme: dark)').matches) }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $identitas->nama_aplikasi ?? 'Rencana Media' }}</title>
    <!-- Google Font: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js & SweetAlert2 -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .kaca {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 dark:bg-[#0b0f19] dark:text-slate-100 min-h-screen transition-colors duration-300 flex flex-col antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Efek Gradasi Latar Belakang -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10 opacity-40 dark:opacity-25">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-500 rounded-full blur-[128px]"></div>
        <div class="absolute top-1/2 -left-40 w-96 h-96 bg-purple-500 rounded-full blur-[128px]"></div>
    </div>

    <!-- Navigasi Atas -->
    <header class="border-b border-slate-200/80 dark:border-slate-800/80 bg-white/70 dark:bg-[#0b0f19]/70 kaca sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between py-3">
            <a href="{{ route('beranda') }}" class="flex items-center gap-3.5 group">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-violet-500 flex items-center justify-center text-white font-black shadow-lg shadow-indigo-500/25 group-hover:scale-105 transition duration-300">
                    RM
                </div>
                <div>
                    <span class="font-extrabold text-lg tracking-tight text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">{{ $identitas->nama_aplikasi ?? 'Rencana Media' }}</span>
                    <span class="block text-[10px] uppercase font-semibold tracking-widest text-slate-400">Sistem Perencanaan Konten</span>
                </div>
            </a>

            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Tombol Ganti Tema -->
                <button 
                    @click="modeGelap = !modeGelap; localStorage.setItem('tema', modeGelap ? 'gelap' : 'terang')"
                    class="p-2.5 rounded-xl bg-slate-100/80 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/60 text-slate-600 dark:text-slate-300 hover:scale-105 transition"
                    title="Ubah Tema">
                    <span x-show="!modeGelap" class="text-sm">🌙</span>
                    <span x-show="modeGelap" class="text-sm">☀️</span>
                </button>

                @if(auth('admin')->check())
                    <a href="{{ route('admin.dasbor') }}" class="text-xs sm:text-sm font-semibold px-4 py-2 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 border border-indigo-200/50 dark:border-indigo-800/50 hover:bg-indigo-100 transition">Panel Admin</a>
                    <form action="{{ route('keluar') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs px-3.5 py-2 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-500/20 font-semibold transition">Keluar</button>
                    </form>
                @elseif(auth('operator')->check())
                    <a href="{{ route('operator.dasbor') }}" class="text-xs sm:text-sm font-semibold px-4 py-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-800/50 hover:bg-emerald-100 transition">Panel Operator</a>
                    <form action="{{ route('keluar') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs px-3.5 py-2 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-500/20 font-semibold transition">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('masuk') }}" class="text-xs sm:text-sm px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/50 hover:-translate-y-0.5 transition duration-200">
                        Masuk Sistem
                    </a>
                @endif
            </div>
        </div>
    </header>

    <!-- Konten Utama Halaman -->
    <main class="flex-1">
        @yield('konten')
    </main>

    <!-- Kaki Halaman -->
    <footer class="border-t border-slate-200/80 dark:border-slate-800/80 py-8 text-center text-xs text-slate-500 dark:text-slate-400 bg-white/50 dark:bg-[#0b0f19]/50 kaca">
        <p>{{ $identitas->teks_footer ?? '© 2026 Rencana Media. Hak cipta dilindungi.' }}</p>
    </footer>

    <!-- Notifikasi SweetAlert -->
    @if(session('sukses'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('sukses') }}',
                timer: 3000,
                showConfirmButton: false,
                customClass: { popup: 'rounded-2xl dark:bg-slate-900 dark:text-white dark:border dark:border-slate-800' }
            });
        </script>
    @endif

    @if(session('galat'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Perhatian!',
                text: '{{ session('galat') }}',
                customClass: { popup: 'rounded-2xl dark:bg-slate-900 dark:text-white dark:border dark:border-slate-800' }
            });
        </script>
    @endif
</body>
</html>
