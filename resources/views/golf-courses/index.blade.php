<x-layout>
    <x-slot:title>ゴルフ場一覧</x-slot:title>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">ゴルフ場一覧</h2>
        <div class="flex space-x-2 w-full md:w-auto">
            <a href="{{ route('golf-courses.create') }}" class="flex-1 md:flex-initial text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-150">
                新規作成
            </a>
            <a href="{{ route('golf-courses.trashed') }}" class="flex-1 md:flex-initial text-center bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-150">
                削除済一覧
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('golf-courses.index') }}" class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">キーワード</label>
                <input type="text" name="q" value="{{ request('q') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">都道府県</label>
                <input type="text" name="prefecture" value="{{ request('prefecture') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">locale</label>
                <select name="locale" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
                    <option value="">選択してください</option>
                    <option value="ja" {{ request('locale') === 'ja' ? 'selected' : '' }}>ja</option>
                    <option value="en" {{ request('locale') === 'en' ? 'selected' : '' }}>en</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">種別</label>
                <select name="kind" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
                    <option value="">選択してください</option>
                    <option value="indoor" {{ request('kind') === 'indoor' ? 'selected' : '' }}>indoor</option>
                    <option value="outdoor" {{ request('kind') === 'outdoor' ? 'selected' : '' }}>outdoor</option>
                    <option value="short" {{ request('kind') === 'short' ? 'selected' : '' }}>short</option>
                    <option value="long" {{ request('kind') === 'long' ? 'selected' : '' }}>long</option>
                </select>
            </div>
        </div>
        <div class="mt-4 flex justify-end space-x-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded transition duration-150">
                検索
            </button>
            <a href="{{ route('golf-courses.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-6 rounded transition duration-150">
                クリア
            </a>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">施設名</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">都道府県</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">locale</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">種別</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">電話</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($golfCourses as $golfCourse)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $golfCourse->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $golfCourse->course_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $golfCourse->state_prefecture }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $golfCourse->locale }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @foreach (['indoor', 'outdoor', 'short_course', 'long_course'] as $flag)
                                @if ($golfCourse->$flag)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1">
                                        {{ str_replace('_course', '', $flag) }}
                                    </span>
                                @endif
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $golfCourse->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('golf-courses.show', ['id' => $golfCourse->id]) }}" class="text-blue-600 hover:text-blue-900 transition duration-150">詳細</a>
                            <a href="{{ route('golf-courses.edit', ['id' => $golfCourse->id]) }}" class="text-indigo-600 hover:text-indigo-900 transition duration-150">編集</a>
                            <a href="{{ route('golf-courses.delete', ['id' => $golfCourse->id]) }}" class="text-red-600 hover:text-red-900 transition duration-150">削除</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">
                            該当するゴルフ場が見つかりませんでした。
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $golfCourses->links() }}
    </div>
</x-layout>
