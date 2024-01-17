<header class="bg-gray-800 text-gray-200 fixed top-0 left-0 right-0  z-50 lg:px-20">
    <div class="container mx-auto p-3">
        <div class="flex items-center justify-between">
            <a class="text-lg hover:text-gray-300" href="/">
                {{ config('app.name') }}
            </a>
            <div class="flex items-center">
                <!--認証のチェック-->
                @if (Auth::check())
                <a class="text-sm hover:text-gray-400 md:hidden" href="{{ route('photos.index') }}">ホーム</a>

                    <!--スマホ用-->
                    <div class="mr-5 md:hidden">                        
                        <x-dropdown>
                            <x-slot name="trigger">
                                <button class="text-sm hover:text-gray-400 ml-4">メニュー</button>
                            </x-slot>
                                <x-slot name="content">                                    
                                    <x-dropdown-link :href="route('photos.create')">新規登録</x-dropdown-link>
                                    <x-dropdown-link  :href="route('photos.search')">検索&#128269;</x-dropdown-link>
                                    <x-dropdown-link  :href="route('photos.calendar')">カレンダー表示</x-dropdown-link>
                                </x-slot>
                        </x-dropdown>
                    </div>

                    <!--大画面用-->
                    <div class="mr-5 hidden md:block">
                        <a class="text-sm hover:text-gray-400" href="{{ route('photos.index') }}">ホーム</a>
                        <a class="text-sm hover:text-gray-400 ml-4" href="{{ route('photos.create') }}">新規登録</a>
                        <a class="text-sm hover:text-gray-400 ml-4" href="{{ route('photos.search') }}">検索&#128269;</a>
                        <a class="text-sm hover:text-gray-400 ml-4" href="{{ route('photos.calendar') }}">カレンダー表示</a>
                    </div>

                <x-dropdown>
                    <x-slot name="trigger">
                        <button class="text-sm hover:text-gray-400">{{ auth()->user()->name }}</button>
                    </x-slot>
                    <x-slot name="content">
                    <x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left">ログアウト</button>
                            </form>
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('profile.edit')">
                            {{ __('アカウント情報') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('contact.index')">
                            {{ __('お問い合わせ')}}
                    </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
                
                @else
                <a class="text-sm hover:text-gray-400" href="{{ route('login') }}">ログイン</a>
                <a class="text-sm hover:text-gray-400 ml-4" href="{{ route('register') }}">サインアップ</a>
                @endif
            </div>
        </div>
    </div>
</header>
