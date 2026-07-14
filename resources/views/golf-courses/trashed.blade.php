<x-layout>
    <x-slot:title>削除済ゴルフ場一覧</x-slot:title>

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">削除済ゴルフ場一覧</h2>
        <a href="{{ route('golf-courses.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded shadow transition duration-150">
            一覧へ戻る
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-20">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">施設名</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-32">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($golfCourses as $golfCourse)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $golfCourse->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $golfCourse->course_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('golf-courses.restore', ['id' => $golfCourse->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-900 font-semibold transition duration-150">
                                    復元
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">
                            削除済データはありません。
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
