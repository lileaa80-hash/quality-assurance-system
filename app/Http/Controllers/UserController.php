<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil semua data user menggunakan Query Builder
        $users = DB::table('users')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        DB::table('users')->insert([
            'name'   => $request->name,
            'email'  => $request->email,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function show($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        DB::table('users')->where('id', $id)->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'status' => $request->status,
            'updated_at' => now(),
        ]);
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}