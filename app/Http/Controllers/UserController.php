<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('pegawai')->latest()->get();
        return view('user.index', compact('users'));
    }
}
