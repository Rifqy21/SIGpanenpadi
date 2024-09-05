<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatControllers extends Controller
{
    public function index()
    {
        $adminId = User::where('role', 'admin')->first()->id;
        $userId = Auth::id();


        return view('chat.index', compact('adminId', 'userId'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
            'admin_id' => 'required|exists:users,id',
            'sender_id' => 'required|exists:users,id'
        ]);

        $message = new Message();
        $message->user_id = Auth::id();
        $message->admin_id = $request->input('admin_id');
        $message->body = $request->input('message');
        $message->sender_id = $request->input('sender_id');
        $message->save();

        return response()->json(['success' => true]);
    }

    public function messages()
    {
        $userId = Auth::id();
        $adminId = User::where('role', 'admin')->first()->id;

        $messages = Message::where(function ($query) use ($userId, $adminId) {
            $query->where('user_id', $userId)->where('admin_id', $adminId)
                ->orWhere('user_id', $adminId)->where('admin_id', $userId);
        })->with('user')->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }
}
