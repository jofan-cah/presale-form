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

    public function toggleFollowUp(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);

        $submission->is_followed_up = !$submission->is_followed_up;

        // Jika ada notes dari request
        if ($request->has('notes')) {
            $submission->follow_up_notes = $request->notes;
        }

        $submission->save();

        return response()->json([
            'success' => true,
            'is_followed_up' => $submission->is_followed_up,
            'message' => $submission->is_followed_up ? 'Ditandai sudah follow up' : 'Ditandai belum follow up'
        ]);
    }
}
