<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrCode;
use App\Models\Setting;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class QrController extends Controller
{
    public function index()
    {
        $qrCodes = QrCode::latest()->get();
        $user = User::find(session('admin_id'));
        return view('admin.qrcodes', compact('qrCodes', 'user'));
    }

    public function generate()
    {
        $token = Str::random(32);
        $url = route('form.show', $token);

        QrCode::create([
            'token' => $token,
            'url' => $url,
        ]);

        return redirect()->route('admin.qrcodes')->with('success', 'QR Code berhasil dibuat!');
    }

    public function show($token)
    {
        $qrCode = QrCode::where('token', $token)->firstOrFail();
        $svg = $this->generateQrWithLogo($qrCode->url);

        return response($svg)
            ->header('Content-Type', 'image/svg+xml');
    }

    public function download($token)
    {
        $qrCode = QrCode::where('token', $token)->firstOrFail();
        $svg = $this->generateQrWithLogo($qrCode->url);

        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="qrcode-' . $token . '.svg"');
    }

    private function generateQrWithLogo($url)
    {
        // Generate base QR code as SVG
        $qrSvg = QrCodeGenerator::format('svg')
            ->size(400)
            ->errorCorrection('H')
            ->generate($url);

        // Get company logo from settings
        $logoPath = Setting::get('company_logo');

        // If no logo, return base QR
        if (!$logoPath || !Storage::disk('public')->exists($logoPath)) {
            return $qrSvg;
        }

        // Read logo and convert to base64
        $logoFullPath = Storage::disk('public')->path($logoPath);
        $logoData = file_get_contents($logoFullPath);
        $logoBase64 = base64_encode($logoData);

        // Get logo mime type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $logoFullPath);
        finfo_close($finfo);

        // Calculate center position for 110x110 logo in 400x400 QR
        $logoSize = 110;
        $x = (400 - $logoSize) / 2;
        $y = (400 - $logoSize) / 2;

        // Background size (sedikit lebih besar dari logo untuk padding)
        $bgSize = 130;
        $bgX = (400 - $bgSize) / 2;
        $bgY = (400 - $bgSize) / 2;

        // Create white background rectangle (rounded corners)
        $background = sprintf(
            '<rect x="%d" y="%d" width="%d" height="%d" rx="5" fill="white"/>',
            $bgX,
            $bgY,
            $bgSize,
            $bgSize
        );

        // Create logo image
        $logoImage = sprintf(
            '<image x="%d" y="%d" width="%d" height="%d" href="data:%s;base64,%s"/>',
            $x,
            $y,
            $logoSize,
            $logoSize,
            $mimeType,
            $logoBase64
        );

        // Insert background + logo before closing </svg> tag
        $qrWithLogo = str_replace('</svg>', $background . $logoImage . '</svg>', $qrSvg);

        return $qrWithLogo;
    }
}
