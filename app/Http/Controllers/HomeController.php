<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\WebIdentity;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $identity = WebIdentity::first() ?? (object)[
            'app_name' => 'Media Plan App',
            'app_description' => 'Aplikasi Manajemen Perencanaan Media Digital.',
            'footer_text' => '© 2026 Media Plan App.',
            'theme_default' => 'dark'
        ];

        $totalProjects = Project::count();
        $inProgressProjects = Project::where('status', 'in_progress')->count();
        $completedProjects = Project::where('status', 'completed')->count();
        $draftProjects = Project::where('status', 'draft')->count();

        $recentProjects = Project::with(['operator', 'details'])->latest()->take(6)->get();

        return view('home', compact(
            'identity',
            'totalProjects',
            'inProgressProjects',
            'completedProjects',
            'draftProjects',
            'recentProjects'
        ));
    }
}
