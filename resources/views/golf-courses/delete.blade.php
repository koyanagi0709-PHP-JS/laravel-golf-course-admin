<x-layout>
    <x-slot:title>ゴルフ場削除確認</x-slot:title>

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-red-600">ゴルフ場削除確認</h2>
        <a href="{{ route('golf-courses.show', ['id' => $golfCourse->id]) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded transition duration-150">
            詳細へ戻る
        </a>
    </div>

    <div class="bg-red-50 border border-red-200 rounded-lg p-6 max-w-xl">
        <p class="text-red-800 font-medium mb-4">以下のゴルフ場を本当に削除しますか？この操作は元に戻せます（ゴミ箱へ移動します）。</p>
        
        <div class="bg-white p-4 rounded border border-red-100 mb-6">
            <span class="block text-xs font-semibold text-gray-500 uppercase">施設名</span>
            <span class="text-lg font-bold text-gray-800">{{ $golfCourse->course_name }}</span>
        </div>

        <form action="{{ route('golf-courses.destroy', ['id' => $golfCourse->id]) }}" method="POST" class="flex items-center space-x-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded shadow transition duration-150">
                削除する
            </button>
            <a href="{{ route('golf-courses.show', ['id' => $golfCourse->id]) }}" class="text-gray-600 hover:text-gray-800 font-medium py-2 px-4">
                キャンセル
            </a>
        </form>
    </div>
</x-layout>
