<x-layout>
    <x-slot:title>ゴルフ場詳細</x-slot:title>

    <!-- アクションボタンエリア -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-2xl font-bold text-gray-800">ゴルフ場詳細: {{ $golfCourse->course_name }}</h2>
        <div class="flex space-x-2 w-full sm:w-auto">
            <a href="{{ route('golf-courses.edit', ['id' => $golfCourse->id]) }}" class="flex-1 sm:flex-initial text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-150">
                編集
            </a>
            <a href="{{ route('golf-courses.delete', ['id' => $golfCourse->id]) }}" class="flex-1 sm:flex-initial text-center bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-150">
                削除
            </a>
            <a href="{{ route('golf-courses.index') }}" class="flex-1 sm:flex-initial text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded shadow transition duration-150">
                一覧へ戻る
            </a>
        </div>
    </div>

    <!-- フラッシュメッセージ表示エリア -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- 
        【登録画像表示エリア】
        登録されている画像（最大3枚）を上部にギャラリーとして配置します。
        登録がない場合は「画像未登録」プレースホルダーを表示します。
    -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">ゴルフ場写真</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach (['image1', 'image2', 'image3'] as $idx => $imageKey)
                <div class="bg-gray-50 border border-gray-200 rounded-lg overflow-hidden p-2">
                    <span class="block text-xs font-semibold text-gray-500 mb-2">画像{{ $idx + 1 }}</span>
                    @if ($golfCourse->$imageKey)
                        <div class="relative h-48 w-full bg-gray-200 rounded overflow-hidden">
                            <a href="{{ asset('storage/' . $golfCourse->$imageKey) }}" target="_blank">
                                <img src="{{ asset('storage/' . $golfCourse->$imageKey) }}" class="object-cover w-full h-full hover:scale-105 transition duration-200" alt="ゴルフ場画像{{ $idx + 1 }}">
                            </a>
                        </div>
                    @else
                        <div class="h-48 w-full bg-gray-100 border border-dashed border-gray-300 rounded flex items-center justify-center">
                            <span class="text-sm text-gray-400">画像はありません</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- 
        【詳細情報テーブルエリア】
        マイグレーションのカラム定義コメントに記載された論理名をラベルとして使用し、
        グリッドシステムを用いてすっきりと見やすいテーブルとして出力します。
    -->
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
        <div class="divide-y divide-gray-200">
            <!-- ID -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">自動採番ID</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->id }}</dd>
            </div>

            <!-- 言語・国コード -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">ロケール (ja/en等)</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->locale }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">国コード (JP/US等)</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->country_code }}</dd>
            </div>

            <!-- 基本情報 -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">施設名（コース名）</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2 font-medium">{{ $golfCourse->course_name }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">都道府県・州名</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->state_prefecture ?? '-' }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">分類コード</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->kinds ?? '-' }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">公式サイトURL</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">
                    @if ($golfCourse->web)
                        <a href="{{ $golfCourse->web }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">
                            {{ $golfCourse->web }}
                        </a>
                    @else
                        -
                    @endif
                </dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">代表電話番号</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->phone ?? '-' }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">住所</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->address ?? '-' }}</dd>
            </div>

            <!-- コース種別フラグ -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">コース種別</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2 flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $golfCourse->indoor ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-400' }}">
                        室内コースか: {{ $golfCourse->indoor ? 'あり' : 'なし' }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $golfCourse->outdoor ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-400' }}">
                        屋外コースか: {{ $golfCourse->outdoor ? 'あり' : 'なし' }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $golfCourse->short_course ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-400' }}">
                        ショートコースを持つか: {{ $golfCourse->short_course ? 'あり' : 'なし' }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $golfCourse->long_course ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-400' }}">
                        ロングコースを持つか: {{ $golfCourse->long_course ? 'あり' : 'なし' }}
                    </span>
                </dd>
            </div>

            <!-- 位置情報 -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">位置情報</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">
                    <div class="mb-4">
                        <span class="font-medium text-gray-500 mr-2">緯度:</span> {{ $golfCourse->lat ?? '未設定' }}
                        <span class="font-medium text-gray-500 ml-4 mr-2">経度:</span> {{ $golfCourse->lng ?? '未設定' }}
                    </div>

                    <!-- 
                        【Google Maps の埋め込み表示】
                        URLパラメータに output=embed を付与することで、Google Mapsのサイト全体ではなく、
                        Webページへの埋め込みに最適化されたコンパクトなUI（地図部分のみ）で表示させることができます。
                        APIキーが不要な標準のURL形式を採用しています。
                    -->
                    @if($golfCourse->lat && $golfCourse->lng)
                        <div class="w-full h-64 rounded-lg shadow-sm overflow-hidden border border-gray-200">
                            <iframe 
                                width="100%" 
                                height="100%" 
                                frameborder="0" 
                                scrolling="no" 
                                marginheight="0" 
                                marginwidth="0" 
                                src="https://maps.google.com/maps?q={{ $golfCourse->lat }},{{ $golfCourse->lng }}&t=&z=15&ie=UTF8&iwloc=&output=embed">
                            </iframe>
                        </div>
                    @else
                        <div class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center border border-dashed border-gray-300">
                            <span class="text-sm text-gray-400">地図情報が登録されていません</span>
                        </div>
                    @endif
                </dd>
            </div>

            <!-- 予約・問い合わせ -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">問い合わせメールアドレス</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">
                    @if ($golfCourse->form_email)
                        <a href="mailto:{{ $golfCourse->form_email }}" class="text-blue-600 hover:underline">
                            {{ $golfCourse->form_email }}
                        </a>
                    @else
                        -
                    @endif
                </dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">予約先URL／番号</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->reservation ?? '-' }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">予約手段（電話/WEB/メール等）</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->reservation_method ?? '-' }}</dd>
            </div>

            <!-- 備考 -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">備考</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2 whitespace-pre-wrap">{{ $golfCourse->remarks ?? '-' }}</dd>
            </div>
        </div>
    </div>
</x-layout>
