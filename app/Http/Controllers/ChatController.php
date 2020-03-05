<?php

namespace App\Http\Controllers;

use App\Events\Message;
use App\Room;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index($room = 1)
    {

        return view('home', ['room' => Room::find($room) ?? 0]);
    }

    public function sendMessage(Request $request)
    {
        Message::dispatch($request->all());
    }
}