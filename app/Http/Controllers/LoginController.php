<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $payload = [
            'name' => $request->name,
            'password' => $request->password
        ];

        $user = User::where('name', $payload['name'])->first();
        if (!$user) {
            Session::flash('errorName', 'User tidak ada!');
            return redirect()->back();
        }

        $checkPassword = Hash::check($payload['password'], $user->password);
        if (!$checkPassword) {
            Session::flash('errorPassword', 'Password salah!');
            return redirect()->back();
        }

        Auth::login($user);

        // Memeriksa peran pengguna
        if ($user->role === 'super admin') {
            return redirect()->route('inventories');
        } elseif ($user->role === 'sales') {
            return redirect()->route('sales.index');
        } elseif ($user->role === 'purchase') {
            return redirect()->route('purchases.index');
        } elseif ($user->role === 'manager') {
            return redirect()->route('sales.index');
        } else {
            abort(403);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
