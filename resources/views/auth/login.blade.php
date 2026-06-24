@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="card p-8">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Login</h2>
        <p class="text-gray-600 mt-2">Masuk ke akun XYZ Sport Anda</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                   class="input-field" placeholder="nama@email.com">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" name="password" id="password" required
                   class="input-field" placeholder="••••••••">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <button type="submit" class="btn-primary w-full">Login</button>

        <div class="text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-brand-700 hover:text-brand-800 font-medium">Daftar sekarang</a>
            </p>
        </div>
    </form>
</div>
@endsection
