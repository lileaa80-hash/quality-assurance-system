<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = DB::table('notifications')->latest()->get();

        return view('notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'notifiable_type' => 'required',
            'notifiable_id' => 'required',
            'data' => 'required',
        ]);

        DB::table('notifications')->insert([
            'id' => Str::uuid(),
            'type' => $request->type,
            'notifiable_type' => $request->notifiable_type,
            'notifiable_id' => $request->notifiable_id,
            'data' => $request->data,
            'read_at' => $request->read_at,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('notifications.index')
            ->with('success', 'Notification created successfully!');
    }

    public function show($id)
    {
        $notification = DB::table('notifications')
            ->where('id', $id)
            ->first();

        return view('notifications.show', compact('notification'));
    }

    public function edit($id)
    {
        $notification = DB::table('notifications')
            ->where('id', $id)
            ->first();

        return view('notifications.edit', compact('notification'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
            'notifiable_type' => 'required',
            'notifiable_id' => 'required',
            'data' => 'required',
        ]);

        DB::table('notifications')
            ->where('id', $id)
            ->update([
                'type' => $request->type,
                'notifiable_type' => $request->notifiable_type,
                'notifiable_id' => $request->notifiable_id,
                'data' => $request->data,
                'read_at' => $request->read_at,
                'updated_at' => now(),
            ]);

        return redirect()->route('notifications.index')
            ->with('success', 'Notification updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('notifications')
            ->where('id', $id)
            ->delete();

        return redirect()->route('notifications.index')
            ->with('success', 'Notification deleted successfully!');
    }
}