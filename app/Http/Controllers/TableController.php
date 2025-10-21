<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        return view('tables.index', compact('tables'));
    }

    public function create()
    {
        return view('tables.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $table = Table::create(['name' => $request->name]);

        // generate QR
        $fileName = 'table_' . $table->id . '.svg';
        $path = 'qrcodes/' . $fileName;

        QrCode::format('svg')
            ->size(300)
            ->generate(url('/order/' . $table->id), public_path($path));

        $table->update(['qr_code' => $path]);

        return redirect()->route('tables.index')->with('success', 'Meja berhasil dibuat!');
    }

    public function edit(Table $table)
    {
        return view('tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $table->update(['name' => $request->name]);

        return redirect()->route('tables.index')->with('success', 'Meja berhasil diperbarui!');
    }

    public function destroy(Table $table)
    {
        // hapus file QR jika ada
        if ($table->qr_code && File::exists(public_path($table->qr_code))) {
            File::delete(public_path($table->qr_code));
        }

        $table->delete();

        return redirect()->route('tables.index')->with('success', 'Meja berhasil dihapus!');
    }
}
