<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'name'=>"$request->name",
            'email'=>"$request->email",
            'password'=>Hash::make($request->password),
        ]);
        
        Auth::login($user);

        return view('auth.verify');
    }
}
