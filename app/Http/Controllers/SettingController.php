<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SettingService;

class SettingController extends Controller
{
    private SettingService $service;

    public function __construct(SettingService $service)
    {
        $this->service = $service;

        // Pengaturan aplikasi hanya untuk Admin
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                abort(403, 'Akses ditolak. Anda tidak memiliki hak akses.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $app_name = $this->service->getAppName();
        $app_logo = asset($this->service->getAppLogo());

        return view('pages.settings.index', compact('app_name', 'app_logo'));
    }

    public function preview(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('settings', 'public');
            $logoPath = 'storage/' . $logoPath;
        }

        $this->service->updateAppIdentity($validated['app_name'], $logoPath);

        return redirect()->route('settings.index')->with('success', 'Pengaturan aplikasi berhasil diperbarui untuk semua pengguna.');
    }
}
