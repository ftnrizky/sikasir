@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Manajemen User</h2>

    @if(session('success'))
    <div class="bg-green-200 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="min-w-full bg-white shadow rounded-lg">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Role Sekarang</th>
                <th class="px-4 py-2">Ganti Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2">{{ $user->getRoleNames()->first() ?? '-' }}</td>
                <td class="px-4 py-2">
                    <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="role" class="border rounded p-1 mr-2">
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Simpan</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection