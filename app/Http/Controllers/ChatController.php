<?php

namespace App\Http\Controllers;

use App\Events\Message;
use App\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

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
        $message = Arr::add($request->all(), 'timestamp', Carbon::now()->toDateTimeString());
        $user = Auth::user();
        Message::dispatch(compact('message', 'user'));
    }
}