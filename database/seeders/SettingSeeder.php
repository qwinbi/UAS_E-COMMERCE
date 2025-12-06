<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $aboutText = "Nama: Syarifatul Azkiya Alganjari
NIM: 241011701321
Kelas: 03SIFP014
Mata Kuliah: Rekayasa Web
WEB INI DIBUAT UNTUK MENYELESAIKAN TUGAS UAS DARI IBU MEGA PERMATA SAPANI S.KOM., M.KOM.";

        Setting::setValue('logo_path', 'logo/default-logo.png');
        Setting::setValue('footer_text', '© 2024 BUNNYPOPS - All rights reserved | Built with 🐰 for UAS Web Engineering');
        Setting::setValue('about_text', $aboutText);
        Setting::setValue('qris_image_path', null);
    }
}