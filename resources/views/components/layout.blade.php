<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'ゴルフ場管理システム' }}</title>
    
    <!-- Vite CSS/JS assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">
    <div class="min-h-screen flex flex-col justify-between">
        <!-- 共通ヘッダー -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">
                    <a href="{{ route('golf-courses.index') }}" class="hover:text-blue-600 transition duration-150">
                        ゴルフ場管理システム
                    </a>
                </h1>
            </div>
        </header>

        <!-- メインコンテンツ -->
        <main class="flex-grow max-w-7xl w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow mt-6">
                {{ $slot }}
            </div>
        </main>

        <!-- 共通フッター -->
        <footer class="bg-white border-t border-gray-200 py-4 mt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} ゴルフ場管理システム. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html>
