<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\Project;
use App\Models\WebIdentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $identity = WebIdentity::first();
        $totalOperators = Operator::count();
        $totalProjects = Project::count();
        $operators = Operator::latest()->get();

        return view('admin.dashboard', compact('identity', 'totalOperators', 'totalProjects', 'operators'));
    }

    public function updateIdentity(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:100',
            'app_description' => 'nullable|string',
            'footer_text' => 'nullable|string|max:150',
            'theme_default' => 'required|in:light,dark',
        ]);

        $identity = WebIdentity::firstOrCreate(['id' => 1]);
        $identity->update($request->only('app_name', 'app_description', 'footer_text', 'theme_default'));

        return back()->with('success', 'Identitas Website berhasil diperbarui!');
    }

    public function storeOperator(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|unique:operators,username|max:50',
            'email' => 'required|email|unique:operators,email|max:100',
            'password' => 'required|string|min:6',
        ]);

        Operator::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_by_admin_id' => auth('admin')->id(),
        ]);

        return back()->with('success', 'Operator baru berhasil ditambahkan!');
    }

    public function destroyOperator($id)
    {
        $operator = Operator::findOrFail($id);
        $operator->delete();

        return back()->with('success', 'Operator berhasil dihapus!');
    }
}
