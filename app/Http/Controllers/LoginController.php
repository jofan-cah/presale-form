<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('nip', $request->nip)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session([
                'admin_logged_in' => true,
                'admin_id' => $user->id,
                'admin_name' => $user->name,
                'admin_nip' => $user->nip,
            ]);

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['nip' => 'NIP atau Password salah.']);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
