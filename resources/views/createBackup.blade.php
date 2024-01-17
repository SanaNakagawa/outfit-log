<x-app-layout>
    @if(isset($sessionData['photo']))
    <p>{{$sessionData['photo']->filename}}</p>
    <img 
            src="{{ $sessionData['photo']->photo_url }}" 
            alto="photo by {{ $sessionData['photo']->user->name }}" 
            class=" p-2 object-scale-down w-50 h-70 "
                />
    @endif

    <form action="{{ route('photos.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <!--画像ファイルのアップロードフォーム-->
        <label for="file">画像ファイル：</label>
        <input type="file" name="file" id="image" onchange="previewImage(this);">
        <img id="imagePreview" src="#" alt="Image Preview" class="max-w-full mx-auto mb-2" style="display: none; max-width: 300px;">


        <div>
            <!--ジャケットの選択-->
            <label for="jacket_id">ジャケット：</label>
            <select name="jacket_id">
                @if( !isset($sessionData['jacket']) || $sessionData['jacket'] === null )
                    <option value="">選択してください</option>
                @endif
                    @foreach($jackets as $jacket)
                        <option value="{{ $jacket->id }}" {{ isset($sessionData['jacket']) && $sessionData['jacket'] === $jacket->id ? 'selected' : ''}}>
                            {{ $jacket->name }}
                        </option>
                    @endforeach
            </select>

            <label for="jacket_color_id">ジャケットの色：</label>
            <select name="jacket_color_id">
                @if( !isset($sessionData['jacketColor']) || $sessionData['jacketColor'] === null)
                    <option value="">選択してください</option>
                @endif
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}" {{ isset($sessionData['jacketColor']) && $sessionData['jacketColor'] === $color->id ? 'selected' : ''}}>
                            {{ $color->name }}
                        </option>
                    @endforeach
            </select>
        </div>   
        
        <div>
            <!--トップスの選択-->
            <label for="top_id">トップス：</label>
            <select name="top_id">
                @if( !isset($sessionData['top']) || $sessionData['top'] === null)
                    <option value="">選択してください</option>
                @endif
                    @foreach($tops as $top)
                        <option value="{{ $top->id }}" {{ isset($sessionData['top']) && $sessionData['top'] === $top->id ? 'selected' : ''}}>
                            {{ $top->name }}
                        </option>
                    @endforeach
            </select>

            <label for="top_color_id">トップスの色：</label>
            <select name="top_color_id">
                @if( !isset($sessionData['topColor']) || $sessionData['topColor'] === null)
                    <option value="">選択してください</option>
                @endif
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}" {{ isset($sessionData['topColor']) && $sessionData['topColor'] === $color->id ? 'selected' : ''}}>
                            {{ $color->name }}
                        </option>
                    @endforeach
            </select>
        </div>

        <div>
            <!--ボトムスの選択-->
            <label for="bottm_id">ボトムス：</label>
            <select name="bottom_id">
                @if( !isset($sessionData['bottom']) || $sessionData['bottom'] === null)
                    <option value="">選択してください</option>
                @endif
                    @foreach($bottoms as $bottom)
                        <option value="{{ $bottom->id }}" {{ isset($sessionData['bottom']) && $sessionData['bottom'] === $bottom->id ? 'selected' : ''}}>
                            {{ $bottom->name }}
                        </option>
                    @endforeach
            </select>

            <label for="bottom_color_id">ボトムスの色：</label>
            <select name="bottom_color_id">
                @if( !isset($sessionData['bottomColor']) || $sessionData['bottomColor'] === null)
                    <option value="">選択してください</option>
                @endif
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}" {{ isset($sessionData['bottomColor']) && $sessionData['bottomColor'] === $color->id ? 'selected' : ''}}>
                            {{ $color->name }}
                        </option>
                    @endforeach
            </select>
        </div>

        <div>
            <!--靴の選択-->
            <label for="shoe_id">靴：</label>
            <select name="shoe_id">
                @if( !isset($sessionData['shoe']) || $sessionData['shoe'] === null)
                    <option value="">選択してください</option>
                @endif
                    @foreach($shoes as $shoe)
                        <option value="{{ $shoe->id }}" {{ isset($sessionData['shoe']) && $sessionData['shoe'] === $shoe->id ? 'selected' : ''}}>
                            {{ $shoe->name }}
                        </option>
                    @endforeach
            </select>

            <label for="shoe_color_id">靴の色：</label>
            <select name="shoe_color_id">
                @if( !isset($sessionData['shoeColor']) || $sessionData['shoeColor'] === null)
                    <option value="">選択してください</option>
                @endif
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}" {{ isset($sessionData['showColor']) && $sessionData['shoeColor'] === $color->id ? 'selected' : ''}}>
                            {{ $color->name }}
                        </option>
                    @endforeach
            </select>
        </div>


        <div>
            <!--投稿日の選択-->
            <label for="selected_darw">撮影日：</label>
            <input type="text" name="selected_date" class="datepicker" required>
        </div>

        <div>
            <label for="prefecture">地域</label>
            <select name="prefecture">
            @foreach($prefectures as $jap =>$eng)
                <option value="{{$eng}}" {{ isset($userPrefecture) && $userPrefecture === $eng ? 'selected' : '' }}>
                    {{ $jap }}
                </option>
            @endforeach
            </select>
        </div>

    <button class="bg-gray-600 text-white p-2 hover:bg-gray-800" type="submit">アップロード</button>
    </form>

    <!--画像一覧に戻る-->
    <a href="{{ route('photos.index') }}">画像一覧に戻る</a>

    <script>
        function previewImage(input) {
        var file = input.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block'; 
            }
            reader.readAsDataURL(file);
        }
    }
    </script>


</x-app-layout>

