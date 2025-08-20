<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionItemController extends Controller
{
    public function index()
    {
        $transactionItems = TransactionItem::with('product', 'transaction.user')->latest()->paginate(10);
        return view('transaction_items.index', compact('transactionItems'));
    }

    public function create()
    {
        $products = Product::all();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,qris'
        ]);

        $total = 0;
        foreach ($request->products as $item) {
            $product = Product::find($item['product_id']);
            $total += $product->harga_jual * $item['qty'];
        }

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'invoice' => 'INV-' . strtoupper(Str::random(8)),
            'total' => $total,
            'payment_method' => $request->payment_method,
            'status' => 'paid'
        ]);

        foreach ($request->products as $item) {
            $product = Product::find($item['product_id']);
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'harga_jual' => $product->harga_jual,
                'subtotal' => $product->harga_jual * $item['qty']
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('items.product', 'user');
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        abort(404); // Edit transaksi biasanya tidak diperlukan
    }

    public function update(Request $request, Transaction $transaction)
    {
        abort(404); // Update transaksi biasanya tidak dilakukan
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}