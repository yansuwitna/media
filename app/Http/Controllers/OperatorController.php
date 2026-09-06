<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectDetail;
use App\Models\UploadLocation;
use App\Models\WebIdentity;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function dashboard()
    {
        $identity = WebIdentity::first();
        $operator = auth('operator')->user();
        
        $projects = Project::where('operator_id', $operator->id)->with('details.uploadLocation')->latest()->get();
        $uploadLocations = UploadLocation::where('operator_id', $operator->id)->latest()->get();

        return view('operator.dashboard', compact('identity', 'operator', 'projects', 'uploadLocations'));
    }

    public function storeLocation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        UploadLocation::create([
            'operator_id' => auth('operator')->id(),
            'name' => $request->name,
            'url' => $request->url,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Lokasi Upload baru berhasil ditambahkan!');
    }

    public function destroyLocation($id)
    {
        $location = UploadLocation::where('operator_id', auth('operator')->id())->findOrFail($id);
        $location->delete();

        return back()->with('success', 'Lokasi Upload berhasil dihapus!');
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'target_date' => 'nullable|date',
            'status' => 'required|in:draft,in_progress,completed,cancelled',
        ]);

        Project::create([
            'operator_id' => auth('operator')->id(),
            'title' => $request->title,
            'description' => $request->description,
            'target_date' => $request->target_date,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Proyek Rencana Media baru berhasil dibuat!');
    }

    public function destroyProject($id)
    {
        $project = Project::where('operator_id', auth('operator')->id())->findOrFail($id);
        $project->delete();

        return back()->with('success', 'Proyek berhasil dihapus!');
    }

    public function storeDetail(Request $request, $projectId)
    {
        $project = Project::where('operator_id', auth('operator')->id())->findOrFail($projectId);

        $request->validate([
            'item_name' => 'required|string|max:150',
            'upload_location_id' => 'nullable|exists:upload_locations,id',
            'media_type' => 'required|in:video,image,audio,article,other',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,ready,uploaded',
        ]);

        ProjectDetail::create([
            'project_id' => $project->id,
            'upload_location_id' => $request->upload_location_id,
            'item_name' => $request->item_name,
            'media_type' => $request->media_type,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Rincian konten proyek berhasil ditambahkan!');
    }

    public function destroyDetail($id)
    {
        $detail = ProjectDetail::whereHas('project', function ($q) {
            $q->where('operator_id', auth('operator')->id());
        })->findOrFail($id);

        $detail->delete();

        return back()->with('success', 'Rincian konten berhasil dihapus!');
    }
}
