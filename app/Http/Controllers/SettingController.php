<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function __construct()
    {
        // Pengaturan aplikasi hanya untuk Admin
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                abort(403, 'Akses ditolak. Anda tidak memiliki hak akses.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
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
            $app_logo = $request->session()->get('app_logo', $app_logo);
        }

        $request->session()->put('app_name', $app_name);
        $request->session()->put('app_logo', $app_logo);

        return redirect()->route('dashboard');
    }
}
