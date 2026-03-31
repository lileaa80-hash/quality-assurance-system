<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user dengan pagination.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan form tambah user baru.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Menyimpan user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'status'   => 'required|in:active,inactive',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'status'   => $request->status,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Menampilkan detail user
     */
    public function show(User $user)
    {
        // Mengambil dokumen milik user ini agar variabel $documents tersedia di Blade
        $documents = Document::where('created_by', $user->id)->get();

        return view('users.show', compact('user', 'documents'));
    }

    /**
     * Menampilkan form edit user
     */
    public function edit(User $user)
    {
        // Mengambil dokumen agar @forelse($documents as $doc) tidak error
        $documents = Document::where('created_by', $user->id)->get();

        return view('users.edit', compact('user', 'documents'));
    }

    /**
     * Memperbarui data user.
     */
    public function update(Request $request, User $user)
{
    // 1. Validasi harus pakai 'full_name' sesuai input di Blade
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email'     => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'status'    => 'required', // Kita bebaskan dari in:active agar tidak error case-sensitive
        'password'  => 'nullable|string|min:8|confirmed',
    ]);

    // 2. Mapping data dari form ke kolom database
    $user->name = $request->full_name; // 'full_name' dari form masuk ke kolom 'name'
    $user->email = $request->email;
    $user->status = $request->status;

    // 3. Update password jika diisi
    if ($request->filled('password')) {
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('users.index')
        ->with('success', 'User updated successfully.');
}

    /**
     * Menghapus user
     */
    public function destroy(User $user)
    {
        // Proteksi jika user punya dokumen
        $hasDocuments = Document::where('created_by', $user->id)->exists();

        if ($hasDocuments) {
            return back()->with('error', 'Gagal hapus! User ini masih punya dokumen.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}