<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $companyName = Setting::get('company_name', 'Form Presale');
        $companyLogo = Setting::get('company_logo');
        $eventName = Setting::get('event_name', 'Event Presale');
        $eventDescription = Setting::get('event_description', 'Silakan isi formulir di bawah ini dengan lengkap');
        $formStatus = Setting::get('form_status', 'active');

        return view('admin.settings', compact('companyName', 'companyLogo', 'eventName', 'eventDescription', 'formStatus'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'event_name' => 'required|string|max:255',
            'event_description' => 'required|string|max:500',
            'form_status' => 'required|in:active,inactive',
        ]);

        // Update company name
        Setting::set('company_name', $request->company_name);

        // Update event settings
        Setting::set('event_name', $request->event_name);
        Setting::set('event_description', $request->event_description);
        Setting::set('form_status', $request->form_status);

        // Handle logo upload
        if ($request->hasFile('company_logo')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('company_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $logoPath = $request->file('company_logo')->store('logos', 'public');
            Setting::set('company_logo', $logoPath);
        }

        return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function deleteLogo()
    {
        $logo = Setting::get('company_logo');

        if ($logo && Storage::disk('public')->exists($logo)) {
            Storage::disk('public')->delete($logo);
            Setting::set('company_logo', null);
        }

        return redirect()->route('admin.settings')->with('success', 'Logo berhasil dihapus!');
    }
}
