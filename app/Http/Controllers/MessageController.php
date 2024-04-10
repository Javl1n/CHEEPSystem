<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MessageController extends Controller
{
    public function index() {
        $users = User::whereNot('id', auth()->user()->id)->get();
        
        return view('messages.index' ,[
            'users' => $users
        ]);
    }

}
