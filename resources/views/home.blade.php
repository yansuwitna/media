@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Hero Header -->
    <div class="text-center max-w-3xl mx-auto mb-12">
        <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl text-slate-900 dark:text-white">
            Rencana & Strategi Media Digital
        </h1>
        <p class="mt-4 text-base sm:text-lg text-slate-600 dark:text-slate-400">
            {{ $identity->app_description ?? 'Kelola eksekusi rencana media, distribusi channel publikasi, dan rincian konten secara kolaboratif.' }}
        </p>
    </div>

    <!-- Stat Cards (Jumlah Proyek) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/60 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl font-bold">
                📁
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider font-semibold text-slate-500 dark:text-slate-400">Total Proyek</p>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $totalProjects }}</h3>
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/60 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl font-bold">
                ⚡
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider font-semibold text-slate-500 dark:text-slate-400">Dalam Pengerjaan</p>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $inProgressProjects }}</h3>
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/60 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl font-bold">
                ✅
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider font-semibold text-slate-500 dark:text-slate-400">Proyek Selesai</p>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $completedProjects }}</h3>
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/60 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl font-bold">
                📝
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider font-semibold text-slate-500 dark:text-slate-400">Draft Rencana</p>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $draftProjects }}</h3>
            </div>
        </div>
    </div>

    <!-- Recent Projects Overview -->
    <div class="bg-white dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/60 rounded-2xl p-6 sm:p-8">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
            <span>🚀</span> Daftar Rencana Media Terbaru
        </h2>

        @if($recentProjects->isEmpty())
            <div class="text-center py-12 text-slate-500 dark:text-slate-400">
                Belum ada proyek media yang dibuat. Silakan login sebagai operator untuk memulai!
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recentProjects as $project)
                    <div class="p-5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs px-2.5 py-1 rounded-full font-semibold uppercase
                                    @if($project->status == 'completed') bg-emerald-500/10 text-emerald-600 dark:text-emerald-400
                                    @elseif($project->status == 'in_progress') bg-amber-500/10 text-amber-600 dark:text-amber-400
                                    @else bg-slate-500/10 text-slate-600 dark:text-slate-400 @endif">
                                    {{ $project->status }}
                                </span>
                                <span class="text-xs text-slate-400">{{ $project->target_date ?? 'No deadline' }}</span>
                            </div>
                            <h4 class="font-bold text-base text-slate-900 dark:text-white mb-1">{{ $project->title }}</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2 mb-4">{{ $project->description ?? 'Tidak ada catatan proyek.' }}</p>
                        </div>
                        <div class="border-t border-slate-200 dark:border-slate-700/80 pt-3 flex items-center justify-between text-xs text-slate-500">
                            <span>Operator: <strong>{{ $project->operator->name ?? 'Admin' }}</strong></span>
                            <span>{{ $project->details->count() }} Rincian Konten</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
