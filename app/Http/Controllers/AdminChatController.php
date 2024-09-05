<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminChatController extends Controller
{
    public function index(Request $request)
    {
        // Fetch users with optional search by username or email
        $query = User::query()->where('role', 'user');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $adminId = Auth::id();

        $users = $query->with(['messages' => function ($q) {
            $q->orderBy('created_at', 'desc');
        }])->paginate(10);

        // For each user, check if the latest message is from the user and unread by admin

        foreach ($users as $user) {
            $messages = Message::where('user_id', $user->id)
                ->where('admin_id', $adminId)
                ->get();
            foreach ($messages as $key => $msg) {
                if($msg->sender_id != $adminId){
                    $user->has_unreplied_message = true;
                }else {
                    $user->has_unreplied_message = false;
                }
            }
        }
        
        return view('admin.chat.index', compact('users'));
    }


    public function viewConversation($userId)
    {
        $adminId = auth()->id();
        $user = User::findOrFail($userId);
        $messages = Message::where(function ($query) use ($userId, $adminId) {
            $query->where('user_id', $userId)->where('admin_id', $adminId)
                ->orWhere('user_id', $adminId)->where('admin_id', $userId);
        })->with('user')->latest()->get();

        return view('admin.chat.view-conversation', compact('messages', 'userId', 'user', 'adminId'));
    }

    public function fetchMessage($userId)
    {
        // disable intelephense error
        $adminId = auth()->id();
        $messages = Message::where(function ($query) use ($userId, $adminId) {
            $query->where('user_id', $userId)->where('admin_id', $adminId)
                ->orWhere('user_id', $adminId)->where('admin_id', $userId)
                ->orWhere('sender_id', $userId)->where('admin_id', $adminId);
        })->with('user')->with('sender')->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    public function send(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:255',
            'sender_id' => 'required|integer|exists:users,id',
        ]);

        $message = new Message();
        $message->user_id = $userId;  // Admin ID
        $message->admin_id = Auth::id();
        $message->sender_id = $request->sender_id;
        $message->body = $request->input('message');
        $message->save();

        return response()->json(['success' => true]);
    }
}
