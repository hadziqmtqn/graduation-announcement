<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        $title = 'Login';

        return \view('auth.login', compact('title'));
    }

    public function store(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (auth()->attempt($credentials)) {
                // alihkan ke halaman dashboard
                return redirect()->intended(route('dashboard'))
                    ->with('success', 'Selamat datang ' . auth()->user()->name);
            }
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Gagal masuk');
        }

        return to_route('login')->with('error', 'Cek kembali akun Anda');
    }
}
