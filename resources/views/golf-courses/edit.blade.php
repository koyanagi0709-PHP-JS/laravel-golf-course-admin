<x-layout>
    <x-slot:title>ゴルフ場編集</x-slot:title>

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">ゴルフ場編集: {{ $golfCourse->course_name }}</h2>
        <a href="{{ route('golf-courses.show', ['id' => $golfCourse->id]) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded transition duration-150">
            詳細へ戻る
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

    <form action="{{ route('golf-courses.update', ['id' => $golfCourse->id]) }}" method="POST" class="space-y-6 max-w-2xl bg-gray-50 p-6 rounded-lg border border-gray-200">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">locale</label>
                <input type="text" name="locale" value="{{ old('locale', $golfCourse->locale) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">country_code</label>
                <input type="text" name="country_code" value="{{ old('country_code', $golfCourse->country_code) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">state_prefecture</label>
                <input type="text" name="state_prefecture" value="{{ old('state_prefecture', $golfCourse->state_prefecture) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">course_name <span class="text-red-500">*</span></label>
                <input type="text" name="course_name" value="{{ old('course_name', $golfCourse->course_name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">web</label>
                <input type="url" name="web" value="{{ old('web', $golfCourse->web) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">phone</label>
                <input type="text" name="phone" value="{{ old('phone', $golfCourse->phone) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">address</label>
                <input type="text" name="address" value="{{ old('address', $golfCourse->address) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">form_email</label>
                <input type="email" name="form_email" value="{{ old('form_email', $golfCourse->form_email) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">reservation</label>
                <input type="text" name="reservation" value="{{ old('reservation', $golfCourse->reservation) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">reservation_method</label>
                <input type="text" name="reservation_method" value="{{ old('reservation_method', $golfCourse->reservation_method) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">remarks</label>
            <textarea name="remarks" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white px-3 py-2 border">{{ old('remarks', $golfCourse->remarks) }}</textarea>
        </div>

        <div class="flex justify-end pt-4 border-t border-gray-200">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded shadow transition duration-150">
                更新
            </button>
        </div>
    </form>
</x-layout>
