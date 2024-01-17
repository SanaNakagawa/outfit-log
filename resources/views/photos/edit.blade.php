<x-app-layout>
    <div>
        <form action="{{ route('photos.update', $photo->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <!--画像の表示-->
            @if(isset($sessionData['photo']))
                <img 
                    src="{{ $sessionData['photo']->photo_url }}" 
                    alto="photo by {{ $sessionData['photo']->user->name }}" 
                    class="p-2 object-contain h-48 w-96"
                />
                <input type="hidden" name="sessionFileName" value=" {{$sessionData['photo']->filename}}" >
            @endif

            <p class="my-3 text-center sm:text-left">これまでに{{$count}}回登録されています</p>
            
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
                    <label for="top_id" class="mt-2 dark:text-white">トップス ：</label>
                    <div class="flex">                    
                        <x-create-select-item id="top_id" :items="$tops" sessionDataKey="top" :sessionData="$sessionData" />
                        <x-create-select-item id="top_color_id" :items="$colors" sessionDataKey="topColor" :sessionData="$sessionData" />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center">
                    <!--ボトムスの選択-->
                    <label for="bottom_id" class="mt-2 dark:text-white">ボトムス：</label>
                    <div class="flex">
                        <x-create-select-item id="bottom_id" :items="$bottoms" sessionDataKey="bottom" :sessionData="$sessionData" />
                        <x-create-select-item id="bottom_color_id" :items="$colors" sessionDataKey="bottomColor" :sessionData="$sessionData" />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center">
                    <!--靴の選択-->
                    <label for="shoe_id" class="mt-2 dark:text-white">シューズ ：</label>
                    <div class="flex">
                        <x-create-select-item id="shoe_id" :items="$shoes" sessionDataKey="shoe" :sessionData="$sessionData" />
                        <x-create-select-item id="shoe_color_id" :items="$colors" sessionDataKey="shoeColor" :sessionData="$sessionData" />
                    </div>
                </div>
            </div>

            <div class="mt-5 ml-16 flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-2">
                <x-button type="submit" class="mx-auto sm:mr-16 sm:mx-0 max-w-xs">更新</x-button>          

                <!--画像一覧に戻る-->
                <x-button type="button" class="mx-auto sm:mx-0 max-w-xs" onclick="location.href='{{ route('photos.show', $photo) }}'">キャンセル</x-button>                      
            </div>
        </form>

</x-app-layout>