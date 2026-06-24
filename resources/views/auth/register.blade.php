@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="card p-8">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Daftar Akun</h2>
        <p class="text-gray-600 mt-2">Bergabung dengan XYZ Sport</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="input-field" placeholder="John Doe">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                   class="input-field" placeholder="nama@email.com">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                   class="input-field" placeholder="08123456789">
            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" name="password" id="password" required
                   class="input-field" placeholder="Minimal 8 karakter">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                   class="input-field" placeholder="Ulangi password">
        </div>

        <button type="submit" class="btn-primary w-full">Daftar</button>

        <div class="text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-brand-700 hover:text-brand-800 font-medium">Login di sini</a>
            </p>
        </div>
    </form>
</div>
@endsection
