<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Setting;

class FormController extends Controller
{
    public function show()
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

        return view('form', compact('eventName', 'eventDescription'));
    }

    public function store(Request $request)
    {
        // Honeypot check - jika field "website" terisi, berarti bot
        if ($request->filled('website')) {
            // Silent fail untuk bot (redirect tanpa error)
            return redirect()->route('form.show');
        }

        // Check form status before allowing submission
        $formStatus = Setting::get('form_status', 'active');

        if ($formStatus === 'inactive') {
            return redirect()->route('form.index')
                ->with('error', 'Form sedang tidak aktif. Silakan coba lagi nanti.');
        }

        // Enhanced validation dengan sanitization
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z\s\.]+$/' // Hanya huruf, spasi, dan titik
            ],
            'nomor_hp' => [
                'required',
                'string',
                'min:10',
                'max:15',
                'regex:/^[0-9+\-\s]+$/' // Hanya angka, +, -, dan spasi
            ],
            'alamat' => [
                'required',
                'string',
                'min:10',
                'max:1000'
            ],
            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90'
            ],
            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180'
            ],
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nama.min' => 'Nama minimal 3 karakter',
            'nama.regex' => 'Nama hanya boleh berisi huruf dan spasi',
            'nomor_hp.required' => 'Nomor HP wajib diisi',
            'nomor_hp.min' => 'Nomor HP minimal 10 digit',
            'nomor_hp.regex' => 'Format nomor HP tidak valid',
            'alamat.required' => 'Alamat wajib diisi',
            'alamat.min' => 'Alamat minimal 10 karakter',
            'latitude.numeric' => 'Latitude harus berupa angka',
            'latitude.between' => 'Latitude tidak valid',
            'longitude.numeric' => 'Longitude harus berupa angka',
            'longitude.between' => 'Longitude tidak valid',
        ]);

        // Sanitize input data (XSS protection)
        $cleanData = [
            'nama' => strip_tags(trim($validated['nama'])),
            'nomor_hp' => strip_tags(trim($validated['nomor_hp'])),
            'alamat' => strip_tags(trim($validated['alamat'])),
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
        ];

        // Create submission dengan data yang sudah di-sanitize
        Submission::create($cleanData);

        $eventName = Setting::get('event_name', 'Event Presale');
        return redirect()->route('form.success')->with('event_name', $eventName);
    }

    public function success()
    {
        $eventName = session('event_name', Setting::get('event_name', 'Event Presale'));
        return view('success', compact('eventName'));
    }
}
