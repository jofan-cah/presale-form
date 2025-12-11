<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Setting;

class FormController extends Controller
{
    public function show($token = null)
    {
        // Check form status
        $formStatus = Setting::get('form_status', 'active');

        // If form is inactive, show waiting page
        if ($formStatus === 'inactive') {
            $eventName = Setting::get('event_name', 'Event Presale');
            return view('waiting', compact('eventName'));
        }

        // Get event info
        $eventName = Setting::get('event_name', 'Event Presale');
        $eventDescription = Setting::get('event_description', 'Silakan isi formulir di bawah ini dengan lengkap');

        return view('form', compact('token', 'eventName', 'eventDescription'));
    }

    public function store(Request $request)
    {
        // Check form status before allowing submission
        $formStatus = Setting::get('form_status', 'active');

        if ($formStatus === 'inactive') {
            return redirect()->route('form.index')
                ->with('error', 'Form sedang tidak aktif. Silakan coba lagi nanti.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ]);

        Submission::create([
            'nama' => $request->nama,
            'nomor_hp' => $request->nomor_hp,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'qr_token' => $request->token,
        ]);

        $eventName = Setting::get('event_name', 'Event Presale');
        return redirect()->route('form.success')->with('event_name', $eventName);
    }

    public function success()
    {
        $eventName = session('event_name', Setting::get('event_name', 'Event Presale'));
        return view('success', compact('eventName'));
    }
}
