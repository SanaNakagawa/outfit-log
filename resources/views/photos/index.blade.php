<x-app-layout>
    <div class="p-4">
        <div class="bg-white rounded-lg shadow-lg pt-5 p-4">
            <p class="text-xl pb-2">今日({{$today}})の{{$userPrefecture->prefecture->name}}</p>
            <p><span class="text-blue-700">最低気温は{{$todayMinTemp}}℃</span>
                <span class="text-red-700">最高気温は{{$todayMaxTemp}}℃</span>
                の予報です
            </p>
            @if ($maxTempDifference>0 && $minTempDifference>0)
                <p>昨日より最高気温は<span class="text-red-700">+{{$maxTempDifference}}℃</span> 最低気温は<span class="text-red-700">+{{$minTempDifference}}℃</span> の予報です</p>
            @elseif ($maxTempDifference<0 && $minTempDifference>0)
                <p>昨日より最高気温は<span class="text-blue-700">-{{$maxTempDifference*-1}}℃</span> 最低気温は<span class="text-red-700">+{{$minTempDifference}}℃</span> の予報です</p>
            @elseif ($maxTempDifference>0 && $minTempDifference<0)
                <p>昨日より最低気温は<span class="text-red-700">+{{$maxTempDifference}}℃</span> 最低気温は<span class="text-blue-700">-{{$minTempDifference*-1}}℃</span> の予報です</p>
            @elseif ($maxTempDifference<0 && $minTempDifference<0)
                <p>昨日より最低気温は<span class="text-blue-700">-{{$maxTempDifference*-1}}℃</span> 最低気温は<span class="text-blue-700">-{{$minTempDifference*-1}}℃</span> の予報です</p>
            @endif

            <div class="text-right text-xs">
                <!-- 「Open-Meteo」の帰属表示 -->
                <a href="https://open-meteo.com/">Weather data by Open-Meteo.com</a>
            </div>
        </div>

        <div class="pt-4 text-center sm:text-left">
            <x-button type="button" onclick="location.href='{{ route('photos.create') }}'">新規登録</x-button>
            <x-button type="button" class="ml-4" onclick="location.href='{{ route('photos.calendar') }}'">カレンダー表示</x-button>
            <x-button type="button" class="ml-4" onclick="location.href='{{ route('photos.search') }}'">検索</x-button>
        </div>

        <div class="pt-5">
            @if ($photos->isNotEmpty())
                <!--画像一覧-->
                <ul class="mt-3 grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6 xl:gap-8">
            @foreach ($photos as $photo)
                <li class="group h-60 flex justify-center items-center bg-gray-100 overflow-hidden rounded shadow-lg relative">
                        <a href="{{ route('photos.show', $photo) }}">
                            <img 
                            src="{{ $photo->photo_url }}" 
                            alto="photo by {{ $photo->user->name }}" 
                            class="w-full h-full object-cover object-center absolute inset-0 group-hover:scale-105 transition duration-200"
                            />
                        </a>
                        
                        <!--削除ボタン-->       
                        <form 
                            class="hodden group-hover:block absolute top-0 right-0 mt-2" 
                            onsubmit="return confirm('本当に削除しますか？')"
                            action="{{ route('photos.destroy', $photo) }}" method="post">
                            
                            @csrf
                            @method('delete')
                            <button class="bg-black bg-opacity-30 hover:bg-gray-600 text-white md:text-sm border border-gray-400 rounded-lg px-2 md:px-3 py-1 mr-3 mb-3">&times;</button>
                        </form>
                        
                        <!--撮影日と気温の表示-->
                        <div class="absolute bottom-0 left-0 right-0 bg-gray-100 text-center text-xs p-2">
                        
                        {{ \Carbon\Carbon::parse($photo->selected_date)->format('n/j') }}
                        @if(isset($photo->weathers->min_temperature))
                        [{{ $photo->weathers->min_temperature }}~{{ $photo->weathers->max_temperature }}℃]
                        @endif
                        </div>
                    </li>
                    @endforeach
                </ul>

                <!-- ページネーション -->
                @if ($photos->lastPage() > 1)
                <div class="mt-4 px-4 py-1 rounded bg-gray-300">
                    {{ $photos->links() }}
                </div>
                @endif
                
            @else
                <p class="mt-10 text-gray-600">まだ投稿がありません</p>
            @endif
        </div>
    </div>
</x-app-layout>