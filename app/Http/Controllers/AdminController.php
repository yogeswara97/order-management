<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage =30;
        $admins = User::where('name', 'like', "%$search%")->paginate($perPage);

        $adminsName = User::select('name')->get();
        $title = "Admin";

        return view('admin.index', compact('admins', 'perPage','title','adminsName'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (session('user')['role'] !== 'super.admin') {
            return redirect()->route('admin.index')
                ->with('error', 'You do not have permission to create admin users.');
        }

        $title = "Create Admin";

        return view('admin.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (session('user')['role'] !== 'super.admin') {
            return redirect()->route('admin.index')
                ->with('error', 'You do not have permission to create admin users.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:admin,super.admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.create')
                ->withErrors($validator)
                ->withInput();
        }

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.index')
            ->with('success', 'Admin created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (session('user')['role'] !== 'super.admin') {
            return redirect()->route('admin.index')
                ->with('error', 'You do not have permission to create admin users.');
        }

        $admin = User::findOrFail($id);

        $title = "Edit Admin";

        return view('admin.edit', compact('admin', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (session('user')['role'] !== 'super.admin') {
            return redirect()->route('admin.index')
                ->with('error', 'You do not have permission to create admin users.');
        }

        $admin = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'role' => 'required|string|in:admin,super.admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.edit', $admin->id)
                ->withErrors($validator)
                ->withInput();
        }

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $admin->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.index')
            ->with('success', 'Admin updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (session('user')['role'] !== 'super.admin') {
            return redirect()->route('admin.index')
                ->with('error', 'You do not have permission to create admin users.');
        }

        $admin = User::findOrFail($id);

        $admin->delete();

        return redirect()->route('admin.index')
            ->with('success', 'Admin deleted successfully.');
    }
}
