<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        // Ambil dari session, kalau tidak ada pakai default
        $app_name = $request->session()->get('app_name', 'Flowbite');
        $app_logo = $request->session()->get('app_logo', '/images/default-logo.png');

        return view('pages.settings.index', compact('app_name', 'app_logo'));
    }

    public function preview(Request $request)
    {
        $app_name = $request->input('app_name', 'Flowbite');
        $app_logo = '/images/default-logo.png';

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('temp', 'public');
            $app_logo = '/storage/' . $path;
        } else {
            // Ambil logo sebelumnya dari session jika ada
            $app_logo = $request->session()->get('app_logo', $app_logo);
        }

        // Simpan ke session
        $request->session()->put('app_name', $app_name);
        $request->session()->put('app_logo', $app_logo);

        // Redirect ke halaman index agar URL tetap rapi & data tersimpan di session
        return redirect()->route('dashboard');
    }
}
