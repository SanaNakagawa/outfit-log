<x-app-layout>
    <form method="POST" action="{{ route('contact.send') }}" class="max-w-lg mx-auto p-8">
        @csrf

        <div class="mb-6">
            <label class="block text-gray-700 text-sm mb-2 dark:text-white">メールアドレス</label>
            <p class="bg-gray-100 rounded border p-3">{{ $inputs['email'] }}</p>
            <input name="email" value="{{ $inputs['email'] }}" type="hidden">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm mb-2 dark:text-white">タイトル</label>
            <p class="bg-gray-100 rounded border p-3">{{ $inputs['title'] }}</p>
            <input name="title" value="{{ $inputs['title'] }}" type="hidden">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm mb-2 dark:text-white">お問い合わせ内容</label>
            <p class="bg-gray-100 rounded border p-3 whitespace-pre-line">{!! nl2br(e($inputs['body'])) !!}</p>
            <input name="body" value="{{ $inputs['body'] }}" type="hidden">
        </div>

        <div class="flex justify-between">
            <x-button type="submit" name="action" value="back" class="bg-gray-500">入力内容修正</x-button>
            <x-button type="submit" name="action" value="submit" class="bg-blue-600 hover:bg-blue-700 font-bold focus:outline-none">送信する</x-button>
        </div>
    </form>
</x-app-layout>
