<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(session('admin_id'));
        return view('admin.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(session('admin_id'));

        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|unique:users,nip,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->nip = $request->nip;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->photo = $photoPath;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Update session
        session([
            'admin_name' => $user->name,
            'admin_nip' => $user->nip,
        ]);

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function deletePhoto()
    {
        $user = User::find(session('admin_id'));

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
            $user->photo = null;
            $user->save();
        }

        return redirect()->route('admin.profile')->with('success', 'Foto berhasil dihapus!');
    }
}
