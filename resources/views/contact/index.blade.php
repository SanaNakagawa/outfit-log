<x-app-layout>
    <form method="POST" action="{{ route('contact.confirm') }}" class="max-w-lg mx-auto p-8">
        @csrf

        <div class="mb-6">
            <label class="block text-gray-700 text-sm mb-1 dark:text-white">メールアドレス (必須)</label>
            <input name="email" value="{{ old('email') }}" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @if ($errors->has('email'))
                <p class="text-red-500 text-xs italic">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm mb-1 dark:text-white">タイトル (必須)</label>
            <input name="title" value="{{ old('title') }}" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @if ($errors->has('title'))
                <p class="text-red-500 text-xs italic">{{ $errors->first('title') }}</p>
            @endif
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm mb-1 dark:text-white">お問い合わせ内容 (必須)</label>
            <textarea name="body" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('body') }}</textarea>
            @if ($errors->has('body'))
                <p class="text-red-500 text-xs italic">{{ $errors->first('body') }}</p>
            @endif
        </div>

        <div class="flex justify-between">
            <x-button type="button" onclick="location.href='{{ route('photos.index') }}'">キャンセル</x-button>
            <x-button type="submit">入力内容確認</x-button>
        </div>
    </form>
</x-app-layout>
