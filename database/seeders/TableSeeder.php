<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan folder qrcodes ada
        $qrFolder = public_path('qrcodes');
        if (!File::exists($qrFolder)) {
            File::makeDirectory($qrFolder, 0755, true);
        }

        for ($i = 1; $i <= 24; $i++) {
            $table = Table::create([
                'name' => 'Ali Akbar ' . $i,
            ]);

            // link unik untuk meja ini
            $url = url('/order/' . $table->id);

            $fileName = "table_{$table->id}.svg";
            $filePath = $qrFolder . '/' . $fileName;

            // Generate QR yang berisi URL unik meja
            QrCode::format('svg')
                ->size(300)
                ->generate($url, $filePath);

            // simpan path ke database
            $table->update([
                'qr_code' => 'qrcodes/' . $fileName,
            ]);
        }

        echo "✅ QR Code unik untuk 20 meja berhasil dibuat!\n";
    }
}
