<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'logo_url' => Setting::getLogoUrl(),
            'footer_text' => Setting::getValue('footer_text', '© 2024 BUNNYPOPS - All rights reserved'),
            'about_text' => Setting::getValue('about_text', ''),
            'qris_image_url' => Setting::getQrisUrl(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan',
            'data' => $settings
        ], 200);
    }

    public function update(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = \Validator::make($request->all(), [
            'footer_text' => 'required|string',
            'about_text' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        Setting::setValue('footer_text', $request->footer_text);
        Setting::setValue('about_text', $request->about_text);

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan berhasil diperbarui',
            'data' => null
        ], 200);
    }
}