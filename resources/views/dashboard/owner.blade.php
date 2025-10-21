@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Dashboard Owner</h1>
    <p>Halo Owner, {{ auth()->user()->name }}!</p>
    <ul>
        <li><a href="#">Lihat Laporan Penjualan</a></li>
        <li><a href="#">Statistik dan Analitik</a></li>
    </ul>
</div>
@endsection
