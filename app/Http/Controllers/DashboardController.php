<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $submissions = Submission::latest()->get();
        $user = User::find(session('admin_id'));
        return view('admin.dashboard', compact('submissions', 'user'));
    }
}
