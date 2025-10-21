@extends('layouts.admin')
@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow mt-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-brown-800 border-b pb-2">Edit User</h1>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="block text-brown-700 text-sm font-semibold mb-2">Nama</label>
                <input type="text" name="name" value="{{ $user->name }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-brown-500 bg-brown-50" required>
            </div>

            <div class="form-group">
                <label class="block text-brown-700 text-sm font-semibold mb-2">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-brown-500 bg-brown-50" required>
            </div>

            <div class="form-group">
                <label class="block text-brown-700 text-sm font-semibold mb-2">
                    Password <span class="text-sm text-brown-500">(kosongkan jika tidak ingin diganti)</span>
                </label>
                <input type="password" name="password" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-brown-500 bg-brown-50">
            </div>

            <div class="form-group">
                <label class="block text-brown-700 text-sm font-semibold mb-2">Role</label>
                <select name="role" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-brown-500 bg-brown-50" required>
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ $user->roles->pluck('name')->contains($role) ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4 mt-6">
                <button type="submit" 
                    class="px-6 py-2 bg-brown-600 text-black rounded-lg hover:bg-brown-700 transition-colors">
                    Update
                </button>
                <a href="{{ route('admin.users.index') }}" 
                    class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Check if there's a success message in the session
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 1500,
            showConfirmButton: false
        });
    @endif
</script>
@endpush
@endsection
