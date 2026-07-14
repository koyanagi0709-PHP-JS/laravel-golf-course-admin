<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>管理者ログイン - ゴルフ場管理システム</title>
    
    <!-- Vite CSS/JS assets (Tailwind CSS の読み込み) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <!-- 画面中央にログインフォームのみを配置するスッキリしたカード型デザイン -->
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl border border-gray-200 shadow-lg">
        <div>
            <h2 class="text-center text-3xl font-extrabold text-gray-900">
                管理者ログイン
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                ゴルフ場管理システムを使用するにはログインしてください。
            </p>
        </div>

        <!-- 
            【エラーメッセージ表示エリア】
            ログイン失敗時や入力チェックに引っかかった際、エラー情報を分かりやすく赤いボックスで表示します。
        -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-red-800">ログインに失敗しました</h3>
                        <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- ログインフォーム -->
        <form class="mt-8 space-y-6" action="{{ route('login.store') }}" method="POST">
            <!-- 
                【@csrf (CSRF保護)】
                Laravelでは、セキュリティ上の理由からPOST送信時にCSRFトークンの付与が必須です。
                これがないと419エラーとなり送信が拒否されます。
            -->
            @csrf

            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="email-address" class="block text-sm font-medium text-gray-700 mb-1">メールアドレス</label>
                    <!-- 
                        【old('email')】
                        送信エラー等で画面が再表示された際に、入力された値を保持してユーザーの二度手間を省きます。
                    -->
                    <input id="email-address" name="email" type="email" autocomplete="email" required 
                        value="{{ old('email') }}" 
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white" 
                        placeholder="admin@example.com">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">パスワード</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white" 
                        placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900 select-none">
                        ログイン状態を維持する
                    </label>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-semibold rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                    ログイン
                </button>
            </div>
        </form>
    </div>
</body>
</html>
