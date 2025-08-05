@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Kasir</h1>
    <p>Halo, {{ auth()->user()->name }}!</p>
    <ul>
        <li><a href="{{ route('products.index') }}">Pilih Produk</a></li>
        <li><a href="#">Proses Transaksi</a></li>
    </ul>
</div>
@endsection
