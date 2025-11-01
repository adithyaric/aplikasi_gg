<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();
        $title = 'Master Data User';
        return view('users.index', compact('users', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nrp' => 'required|string|max:50|unique:users,nrp',
            'pangkat' => 'nullable|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'role' => 'required|in:admin,anggota',
            'password' => 'required|min:6',
            'ttd' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
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
        ]);

        return redirect()->route('users.index')->with('toast_success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nrp' => 'required|string|max:50|unique:users,nrp,' . $user->id,
            'pangkat' => 'nullable|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'role' => 'required|in:admin,anggota',
            'password' => 'nullable|min:6',
            'ttd' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $ttdPath = $user->ttd; // tetap gunakan yang lama kalau tidak upload baru

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
        ]);

        return redirect()->route('users.index')->with('toast_success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
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
