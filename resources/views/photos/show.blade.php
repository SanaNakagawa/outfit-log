<x-app-layout>
    <div class="container mx-auto mt-8 p-4">
        <div class="flex flex-wrap -mx-4">
            <!-- 画像と基本情報 -->
            <div class="w-full md:w-1/3 px-4 mb-4">
                <div class="bg-white rounded-lg shadow-lg p-4">
                    <h2 class="text-2xl font-semibold mb-4">{{ $photo->selected_date }}</h2>
                    <img src="{{ $photo->photo_url }}" alt="photo by {{ $photo->user->name }}" class="max-w-full rounded">
                    <div class="pt-3 text-sm text-gray-600">
                        <p>これまでに{{ $count }}回登録されています</p>
                    </div>
                </div>
            </div>

            <!-- アイテム詳細 -->
            <div class="w-full md:w-1/3 px-4 mb-4">
                <div class="bg-white rounded-lg shadow-lg p-4">
                    <div class="mb-4">
                        <h3 class="font-semibold mb-2">ジャケット:</h3>
                        <p>　{{ $jacket ? $jacket->name . ' (' . $jacketColor->name . ')' : 'なし' }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="font-semibold mb-2">トップス:</h3>
                        <p>　{{ $top ? $top->name . ' (' . $topColor->name . ')' : 'なし' }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="font-semibold mb-2">ボトムス:</h3>
                        <p>　{{ $bottom ? $bottom->name . ' (' . $bottomColor->name . ')' : 'なし' }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="font-semibold mb-2">シューズ:</h3>
                        <p>　{{ $shoe ? $shoe->name . ' (' . $shoeColor->name . ')' : 'なし' }}</p>
                    </div>
                </div>
            </div>

            <!-- 気温と評価セクション -->
            <div class="w-full md:w-1/3 px-4 mb-4">
                <div class="bg-white rounded-lg shadow-lg p-4">
                    <!-- 気温と評価の内容 -->
                    <div class="mb-4">
                        @if(isset($photo->weathers))
                        <p>最高気温：{{ $photo->weathers->max_temperature }}℃</p>
                        <p>最低気温：{{ $photo->weathers->min_temperature }}℃</p>
                        @endif
                    </div>

                    @if(isset($photoRating))
                        <p>この服装は{{ $photoRating->rating->name }}</p>
                            @if(isset($photoRating->comment))
                            <p style="white-space: pre-wrap;">{!! nl2br(htmlspecialchars($photoRating->comment)) !!}</p>
                            @endif
                        <form 
                            method="post" 
                            onsubmit="return confirm('評価を削除しますか？')"
                            action="{{ route('photos.rate.destroy', ['photo' => $photo, 'rating' => $photoRating]) }}">
                            @csrf
                            @method('delete')
                            <x-button type="submit">評価とコメントを削除</x-button>
                        </form>
                    @else
                        <p>この服装は</p>
                        <div class="ml-2">
                            <form method="post" action="{{ route('photo.rate', $photo) }}">
                                @csrf
                                @method('post')
                                <lavel for="cold"><input type="radio" name="rating" value="1">寒かった</lavel><br>
                                <lavel for="good"><input type="radio" name="rating" value="2">ちょうど良かった</lavel><br>
                                <lavel for="hot"><input type="radio" name="rating" value="3">暑かった</lavel><br>
                                <div class="pt-2" id="comment-section">
                                    <textarea name="comment" placeholder="コメントを入力" class="shadow appearance-none rounded py-2 px-3 text-gray-700"></textarea>
                                </div>
                            
                                <div class="mt-4" id="submit-button">
                                    <x-button type="submit">評価する</x-button>
                                </div>
                            </form>
                        </div>  
                    @endif             
                </div>
                
            </div>
        </div>

        <div class="p-4 flex justify-between">
            <!--同じコーディネートを登録-->
            <form action="{{ route('photos.repost', $photo) }}" method="post">
                @csrf
                <x-button type="submit">再利用</x-button>
            </form>
            
            <!--アイテムの編集-->
            <x-button type="button" class="mx-auto sm:mx-0 max-w-xs" onclick="location.href='{{ route('photos.edit', $photo->id) }}'">アイテムの編集</x-button>                      
                
            <!--投稿の削除-->
            <form
                method="post"
                onsubmit="return confirm('この投稿を本当に削除しますか？')"
                action="{{ route('photos.destroy', $photo) }}">
                    @csrf
                    @method('delete')
                    <x-button type="submit">投稿を削除</x-button>
            </form>            
            
        </div>

        <div class="mt-8">
            <h2 class="text-xl dark:text-white">似たトップス</h2>
            <div class="flex flex-wrap -mx-2">
                @foreach($topRelatedPhotos as $topRelatedPhoto)
                <div class="w-1/3 sm:w-1/3 md:w-1/4 lg:w-1/6 p-2">
                        <div class="bg-white rounded-lg shadow-lg p-2 overflow-hidden flex justify-center items-center">
                            <a href="{{ route('photos.show', ['photo' => $topRelatedPhoto->id]) }}">
                                <img src="{{ $topRelatedPhoto->photo_url }}" alt="photo" class="max-w-full rounded">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-8">
            <h2 class="text-xl dark:text-white">似たボトムス</h2>
            <div class="flex flex-wrap -mx-2">
                @foreach($bottomRelatedPhotos as $bottomRelatedPhoto)
                <div class="w-1/3 sm:w-1/3 md:w-1/4 lg:w-1/6 p-2">
                    <div class="bg-white rounded-lg shadow-lg p-2 overflow-hidden flex justify-center items-center">
                        <a href="{{ route('photos.show', ['photo' => $bottomRelatedPhoto->id]) }}">
                            <img src="{{ $bottomRelatedPhoto->photo_url }}" alt="photo" class="max-w-full rounded">
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>




    <!--評価セクションの制御-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // コメントセクションと送信ボタンを隠す
            const commentSection = document.getElementById('comment-section');
            const submitButton = document.getElementById('submit-button');
            commentSection.style.display = 'none';
            submitButton.style.display = 'none';

            // 評価のラジオボタンにイベントリスナーを設定
            const ratingRadios = document.querySelectorAll('input[type="radio"][name="rating"]');
            ratingRadios.forEach(function(radio) {
                radio.addEventListener('change', function() {
                    // ラジオボタンが選択されたらコメントセクションと送信ボタンを表示
                    commentSection.style.display = 'block';
                    submitButton.style.display = 'block';
                });
            });
        });
    </script>

</x-app-layout>
