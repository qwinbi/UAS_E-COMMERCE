<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'logo_path' => Setting::getValue('logo_path', 'logo/default-logo.png'),
            'footer_text' => Setting::getValue('footer_text', '© 2024 BUNNYPOPS - All rights reserved'),
            'about_text' => Setting::getValue('about_text', ''),
            'qris_image_path' => Setting::getValue('qris_image_path'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|max:2048',
            'footer_text' => 'required|string',
            'about_text' => 'required|string',
            'qris_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logo', 'public');
            Setting::setValue('logo_path', $path);
        }

        if ($request->hasFile('qris_image')) {
            $path = $request->file('qris_image')->store('qris', 'public');
            Setting::setValue('qris_image_path', $path);
        }

        Setting::setValue('footer_text', $request->footer_text);
        Setting::setValue('about_text', $request->about_text);

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui!');
    }
}