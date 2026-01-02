<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->isSuperAdmin()) {
            $users = User::withoutGlobalScope('setting_page')->latest()->get();
        } else {
            $users = User::latest()->get();
        }

        $title = 'Master Data User';
        return view('users.index', compact('users', 'title'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nrp' => 'required|string|max:50|unique:users,nrp',
            'pangkat' => 'nullable|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'role' => 'required|in:superadmin,admin,akuntan,ahligizi',
            'password' => 'required|min:6',
            'ttd' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'setting_page_id' => 'nullable|exists:setting_pages,id',
        ], [], [
            'nrp' => 'Username',
            'setting_page_id' => 'Dapur',
        ]);

        $ttdPath = null;
        if ($request->hasFile('ttd')) {
            $file = $request->file('ttd');
            $filename = 'ttd_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('ttd', $file, $filename);
            $ttdPath = 'ttd/' . $filename;
        }

        User::create([
            'name' => $request->name,
            'nrp' => $request->nrp,
            'pangkat' => $request->pangkat,
            'jabatan' => $request->jabatan,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'ttd' => $ttdPath,
            'setting_page_id' => $request->setting_page_id,
        ]);

        return redirect()->route('users.index')->with('toast_success', 'Data berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nrp' => 'required|string|max:50|unique:users,nrp,' . $user->id,
            'pangkat' => 'nullable|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'role' => 'required|in:superadmin,admin,akuntan,ahligizi',
            'password' => 'nullable|min:6',
            'ttd' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            // 'setting_page_id' => 'nullable|exists:setting_pages,id',
        ], [], [
            'nrp' => 'Username',
            // 'setting_page_id' => 'Dapur',
        ]);

        $ttdPath = $user->ttd;

        if ($request->hasFile('ttd')) {
            // Hapus file lama jika ada
            if ($user->ttd && Storage::disk('public')->exists($user->ttd)) {
                Storage::disk('public')->delete($user->ttd);
            }

            $file = $request->file('ttd');
            $filename = 'ttd_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('ttd', $file, $filename);
            $ttdPath = 'ttd/' . $filename;
        }

        $user->update([
            'name' => $request->name,
            'nrp' => $request->nrp,
            'pangkat' => $request->pangkat,
            'jabatan' => $request->jabatan,
            'role' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'ttd' => $ttdPath,
            // 'setting_page_id' => $request->setting_page_id,
        ]);

        return redirect()->route('users.index')->with('toast_success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->ttd && Storage::disk('public')->exists($user->ttd)) {
            Storage::disk('public')->delete($user->ttd);
        }

        $user->delete();

        return redirect()->route('users.index')->with('toast_success', 'Data berhasil dihapus.');
    }
}
