<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Auth') - Iwangsport</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- Desktop: Split Screen --}}
    <div class="min-h-screen flex">
        
        {{-- Left: Brand Panel --}}
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden" style="background: linear-gradient(135deg, #013D29 0%, #025c3e 50%, #013D29 100%);">
            {{-- Decorative circles --}}
            <div class="absolute -top-20 -left-20 w-80 h-80 rounded-full" style="background: rgba(255,255,255,0.04);"></div>
            <div class="absolute bottom-20 -right-16 w-64 h-64 rounded-full" style="background: rgba(255,255,255,0.03);"></div>
            <div class="absolute top-1/3 right-10 w-40 h-40 rounded-full" style="background: rgba(255,255,255,0.05);"></div>

            <div class="relative z-10 flex flex-col justify-between p-12 w-full">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <svg class="w-9 h-9" viewBox="0 0 24 24" fill="none">
                        <path d="M3 3H5L6.6 12.4C6.7 13 7.2 13.5 7.8 13.5H17.2C17.8 13.5 18.3 13 18.4 12.4L19.8 5H6.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="9" cy="19" r="2" fill="white"/>
                        <circle cx="17" cy="19" r="2" fill="white"/>
                    </svg>
                    <span class="text-2xl font-bold text-white tracking-tight">Iwangsport</span>
                </a>

                {{-- Center Content --}}
                <div class="flex-1 flex flex-col justify-center max-w-md">
                    <h1 class="text-4xl font-bold text-white leading-tight mb-4">
                        @yield('brand-heading', 'Sport Collection Premium')
                    </h1>
                    <p class="text-base text-white/60 leading-relaxed">
                        @yield('brand-description', 'Koleksi celana sport premium dengan bahan berkualitas tinggi dan desain modern untuk gaya hidup aktif Anda.')
                    </p>
                    
                    {{-- Features --}}
                    <div class="mt-10 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm text-white/70">Bahan premium & nyaman dipakai</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm text-white/70">Pengiriman cepat ke seluruh Indonesia</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm text-white/70">Garansi pengembalian 7 hari</span>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <p class="text-xs text-white/30">&copy; {{ date('Y') }} Iwangsport. All rights reserved.</p>
            </div>
        </div>

        {{-- Right: Form Panel --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-8 lg:p-12">
            <div class="w-full max-w-md">
                {{-- Mobile Logo --}}
                <div class="lg:hidden text-center mb-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5" style="color: #013D29;">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none">
                            <path d="M3 3H5L6.6 12.4C6.7 13 7.2 13.5 7.8 13.5H17.2C17.8 13.5 18.3 13 18.4 12.4L19.8 5H6.5" stroke="#013D29" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="9" cy="19" r="2" fill="#013D29"/>
                            <circle cx="17" cy="19" r="2" fill="#013D29"/>
                        </svg>
                        <span class="text-2xl font-bold tracking-tight">Iwangsport</span>
                    </a>
                </div>

                @yield('content')
            </div>
        </div>
    </div>

</body>
</html>
