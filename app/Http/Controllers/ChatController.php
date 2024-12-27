<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getChats()
    {
        $chats = Chat::with(['personOne','personTwo','messages.user'])->where('pending',false)->where('person_one_id',auth()->user()->id)->orWhere('person_two_id',auth()->user()->id)->get();
        return response()->json($chats);
    }

    public function getChat($id)
    {
        $chat = Chat::with(['personOne','personTwo','messages.user'])->find($id);
        return response()->json($chat);
    }

    public function getPendingChats()
    {
        $chats = Chat::with(['personOne','personTwo','messages.user'])->where('pending',true)->where('person_one_id',auth()->user()->id)->orWhere('person_two_id',auth()->user()->id)->get();
        return response()->json($chats);
    }

    public function registerMessage(Request $request)
    {
        $chat = Chat::find($request->chat_id);
        ChatMessage::create([
            'chat_id' => $request->chat_id,
            'user_id' => auth()->user()->id,
            'message' => $request->message
        ]);
        event(new ChatEvent($chat->person_one_id));
        event(new ChatEvent($chat->person_two_id));
    }
}
