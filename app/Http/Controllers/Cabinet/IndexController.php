<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\Post;
use App\Models\Tarif;
use App\Models\UserChat;

class IndexController extends Controller
{
    public function __invoke()
    {

        $posts = Post::where('user_id', auth()->id())
            ->with('metro', 'city')
            ->get();

        $tarifList = Tarif::all();

        $notReadMessage = UserChat::where('user_id', auth()->user()->id)
            ->with('notRead')
            ->first();

        return view('new.cabinet.index', compact('posts', 'notReadMessage', 'tarifList'));
    }
}
