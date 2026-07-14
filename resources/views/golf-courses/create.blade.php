<x-layout>
    <x-slot:title>ゴルフ場新規作成</x-slot:title>

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">ゴルフ場新規作成</h2>
        <a href="{{ route('golf-courses.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded transition duration-150">
            一覧へ戻る
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-800 rounded-lg shadow-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 
        【enctype="multipart/form-data" の重要性】
        写真ファイルなどのアップロードを行うフォームには、この属性の記述が必須です。
        記述がない場合、ファイルデータが正しくサーバーへ送信されません。
    -->
    <form action="{{ route('golf-courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-2xl bg-gray-50 p-6 rounded-lg border border-gray-200">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- 各項目名はマイグレーションのコメント(論理名)に合わせて統一・整形しています -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ロケール (ja/en等)</label>
                <input type="text" name="locale" value="{{ old('locale', 'ja') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">国コード (JP/US等)</label>
                <input type="text" name="country_code" value="{{ old('country_code', 'JP') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">都道府県・州名</label>
                <input type="text" name="state_prefecture" value="{{ old('state_prefecture') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">施設名（コース名） <span class="text-red-500">*</span></label>
                <input type="text" name="course_name" value="{{ old('course_name') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">分類コード</label>
                <input type="number" name="kinds" value="{{ old('kinds') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">公式サイトURL</label>
                <input type="url" name="web" value="{{ old('web') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">代表電話番号</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">住所</label>
                <input type="text" name="address" value="{{ old('address') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">問い合わせメールアドレス</label>
                <input type="email" name="form_email" value="{{ old('form_email') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">予約先URL／番号</label>
                <input type="text" name="reservation" value="{{ old('reservation') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">予約手段（電話/WEB/メール等）</label>
                <input type="text" name="reservation_method" value="{{ old('reservation_method') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <!-- 余白合わせ用のダミー要素 -->
            </div>

            <!-- 
                【種別フラグ (チェックボックス)】
                チェックボックスが未チェックの場合、ブラウザからは値が送信されません。
                これを防ぐために、同名の hidden フィールド (value="0") をあらかじめ配置し、
                未チェック時に "0" (false)、チェック時に "1" (true) が送信されるようにしています。
            -->
            <div class="col-span-1 md:col-span-2">
                <span class="block text-sm font-medium text-gray-700 mb-2 border-b pb-1">コース種別</span>
                <div class="grid grid-cols-2 gap-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="hidden" name="indoor" value="0">
                        <input type="checkbox" name="indoor" value="1" {{ old('indoor') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">室内コースか</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="hidden" name="outdoor" value="0">
                        <input type="checkbox" name="outdoor" value="1" {{ old('outdoor') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">屋外コースか</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="hidden" name="short_course" value="0">
                        <input type="checkbox" name="short_course" value="1" {{ old('short_course') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">ショートコースを持つか</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="hidden" name="long_course" value="0">
                        <input type="checkbox" name="long_course" value="1" {{ old('long_course') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">ロングコースを持つか</span>
                    </label>
                </div>
            </div>

            <!-- 位置情報 (緯度・経度) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">緯度 (-90.0〜90.0)</label>
                <input type="number" step="any" name="lat" value="{{ old('lat') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">経度 (-180.0〜180.0)</label>
                <input type="number" step="any" name="lng" value="{{ old('lng') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>

            <!-- 画像アップロード -->
            <div class="col-span-1 md:col-span-2 space-y-4">
                <span class="block text-sm font-medium text-gray-700 border-b pb-2">ゴルフ場写真（最大3枚までアップロード可能）</span>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">画像1ファイルパス</label>
                        <input type="file" name="image1" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">画像2ファイルパス</label>
                        <input type="file" name="image2" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">画像3ファイルパス</label>
                        <input type="file" name="image3" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    </div>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">備考</label>
            <textarea name="remarks" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">{{ old('remarks') }}</textarea>
        </div>

        <div class="flex justify-end pt-4 border-t border-gray-200">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded shadow transition duration-150">
                登録
            </button>
        </div>
    </form>
</x-layout>
