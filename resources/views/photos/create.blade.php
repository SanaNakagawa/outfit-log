<x-app-layout>
    <div>
        <form action="{{ route('photos.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <!--画像の登録-->
            <!--再登録の場合-->
            @if(isset($sessionData['photo']))
                <img 
                    src="{{ $sessionData['photo']->photo_url }}" 
                    alto="photo by {{ $sessionData['photo']->user->name }}" 
                    class="p-2 object-contain h-48 w-96"
                />
                <input type="hidden" name="sessionFileName" value=" {{$sessionData['photo']->filename}}" >
            
            <!--初回登録の場合-->
            @elseif(!isset($sessionData['photo']))
                <label for="file" class="dark:text-white">画像ファイル：</label>
                <input type="file" name="file" id="image" onchange="previewImage(this);"> 
                <img id="imagePreview" src="#" alt="Image Preview" class="object-contain h-48 w-96 mx-auto mb-2" style="display: none;">                       
            @endif

            <!--写真に含まれるアイテムの選択-->
            <div class="p-2">
                <div class="flex flex-col sm:flex-row items-center">
                    <!--ジャケットの選択-->
                    <label for="jacket_id" class="mt-2 dark:text-white">ジャケット：</label>
                    <div class="flex">
                        <x-create-select-item id="jacket_id" :items="$jackets" sessionDataKey="jacket" :sessionData="$sessionData" />
                        <x-create-select-item id="jacket_color_id" :items="$colors" sessionDataKey="jacketColor" :sessionData="$sessionData" />
                    </div>   
                </div>
                
                <div class="flex flex-col sm:flex-row items-center">
                    <!--トップスの選択-->
                    <label for="jacket_id" class="mt-2 dark:text-white">トップス ：</label>
                    <div class="flex">                    
                        <x-create-select-item id="top_id" :items="$tops" sessionDataKey="top" :sessionData="$sessionData" />
                        <x-create-select-item id="top_color_id" :items="$colors" sessionDataKey="topColor" :sessionData="$sessionData" />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center">
                    <!--ボトムスの選択-->
                    <label for="jacket_id" class="mt-2 dark:text-white">ボトムス：</label>
                    <div class="flex">
                        <x-create-select-item id="bottom_id" :items="$bottoms" sessionDataKey="bottom" :sessionData="$sessionData" />
                        <x-create-select-item id="bottom_color_id" :items="$colors" sessionDataKey="bottomColor" :sessionData="$sessionData" />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center">
                    <!--靴の選択-->
                    <label for="jacket_id" class="mt-2 dark:text-white">シューズ ：</label>
                    <div class="flex">
                        <x-create-select-item id="shoe_id" :items="$shoes" sessionDataKey="shoe" :sessionData="$sessionData" />
                        <x-create-select-item id="shoe_color_id" :items="$colors" sessionDataKey="shoeColor" :sessionData="$sessionData" />
                    </div>
                </div>
            </div>

            <div class="p-1 flex flex-col sm:flex-row items-center">
                <div>
                    <!--投稿日の選択-->
                    <label for="selected_darw" class="dark:text-white">撮影日：</label>
                    <input type="text" name="selected_date" class="datepicker" required>
                </div>
            
                <div class="ml-4">
                    <!--気温を取得する都道府県を選択-->
                    <label for="prefecture" class="dark:text-white">地域：</label>
                    <select name="prefecture" class="rounded-sm">
                    @foreach($prefectures as $prefecture)
                        <option value="{{$prefecture->id}}" {{ isset($userPrefecture) && $userPrefecture->prefecture_id === $prefecture->id ? 'selected' : '' }}>
                            {{ $prefecture->name }}
                        </option>
                    @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-5 ml-16 flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-2">
                <x-button type="submit" class="mx-auto sm:mr-16 sm:mx-0 max-w-xs">アップロード</x-button>          

                <!--画像一覧に戻る-->
                <x-button type="button" class="mx-auto sm:mx-0 max-w-xs" onclick="location.href='{{ route('photos.index') }}'">キャンセル</x-button>                      
            </div>
        </form>
    </div>



    <!--datepicker-->
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


    <!--画像のアップロードの検証とドロップダウンリストの制御-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //画像アップロードフォームの検証
            const form = document.querySelector(`form[action="{{ route('photos.store') }}"]`);
            form.addEventListener('submit', function(event) {
                const imageInput = document.querySelector('input[type="file"][name="file"]');
                if (!imageInput.files.length) {
                    alert('画像ファイルを選択してください。');
                    event.preventDefault();
                }
            });

            // 各カテゴリーの処理を関数で設定
            function setupCategory(category) {
                const categorySelect = document.querySelector(`[name="${category}_id"]`);
                const colorSelect = document.querySelector(`[name="${category}_color_id"]`);
                
                //色のドロップダウンリストを隠す
                colorSelect.style.display = categorySelect.value ? 'block' : 'none';

                //アイテムが選択されたときに色のドロップダウンリストを表示
                categorySelect.addEventListener('change', function() {
                    colorSelect.style.display = this.value ? 'block' : 'none';
                });
                
                //色だけ選択されていない場合警告を表示し、フォームを送信しない
                const form = categorySelect.closest('form');
                form.addEventListener('submit', function(event) {
                    if(categorySelect.value && !colorSelect.value) {
                        alert(`${category}の色を選択してください。`);
                        event.preventDefault();
                    }
                });
            }
            setupCategory('jacket');
            setupCategory('top');
            setupCategory('bottom');
            setupCategory('shoe');
        });
    </script>

    



</x-app-layout>

