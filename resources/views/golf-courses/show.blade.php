<x-layout>
    <x-slot:title>ゴルフ場詳細</x-slot:title>

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

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-50 border border-gray-200 rounded-lg overflow-hidden">
        <div class="divide-y divide-gray-200">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">ID</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->id }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">施設名</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2 font-medium">{{ $golfCourse->course_name }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">都道府県</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->state_prefecture }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">国コード</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->country_code }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">web</dt>
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
                <dt class="text-sm font-semibold text-gray-500">phone</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->phone }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">address</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->address }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">form_email</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->form_email }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">reservation</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->reservation }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">reservation_method</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2">{{ $golfCourse->reservation_method }}</dd>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-6 py-4">
                <dt class="text-sm font-semibold text-gray-500">remarks</dt>
                <dd class="text-sm text-gray-900 sm:col-span-2 whitespace-pre-wrap">{{ $golfCourse->remarks }}</dd>
            </div>
        </div>
    </div>
</x-layout>
