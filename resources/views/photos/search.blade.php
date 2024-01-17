<x-app-layout>
    <p class="m-3 dark:text-white text-center sm:text-left">検索するアイテムを選択してください</p>

    <div class="">                
        <form action="{{ route('photos.search') }}" method="get">
            <div class="flex flex-col sm:flex-row items-center">
                <!--ジャケット-->
                <label for="jacket_id" class="mt-2 dark:text-white">ジャケット：</label>
                <div class="flex">
                    <x-search-select-item id="jacket_id"  :items="$jackets" :selectedItem="$jacketId" />
                    <x-search-select-item id="jacket_color"  :items="$colors" :selectedItem="$jacketColorId" />
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center">
                <!--トップス-->
                <label for="jacket_id" class="mt-2 dark:text-white">トップス ：</label>
                <div class="flex">            
                    <x-search-select-item id="top_id"  :items="$tops" :selectedItem="$topId" />
                    <x-search-select-item id="top_color"  :items="$colors" :selectedItem="$topColorId" />
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center">
                <!--ボトムス-->
                <label for="jacket_id" class="mt-2 dark:text-white">ボトムス：</label>
                <div class="flex">                
                    <x-search-select-item id="bottom_id"  :items="$bottoms" :selectedItem="$bottomId" />
                    <x-search-select-item id="bottom_color"  :items="$colors" :selectedItem="$bottomColorId" />
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center">
                <!--靴-->
                <label for="jacket_id" class="mt-2 dark:text-white">シューズ ：</label>
                <div class="flex">            
                    <x-search-select-item id="shoe_id"  :items="$shoes" :selectedItem="$shoeId" />
                    <x-search-select-item id="shoe_color"  :items="$colors" :selectedItem="$shoeColorId" />
                </div>
            </div>

            <div class="mt-5 text-center sm:text-left">
                <x-button type="submit">検索</x-button>

                <x-button type="submit" class="ml-4" id="clearSelection">全選択解除</x-button>
            </div>
        </form>

        @isset($photos)
            @if ($photos->isEmpty())
                <p class="mt-3 text-center sm:text-left">一致するコーディネートは登録されていません</p>
            @else
                <ul class="mt-3 grid grid-cols-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6 xl:gap-8">
                    @foreach ($photos as $photo)
                    <li class="group h-64 flex justify-end items-end bg-gray-100 overflow-hidden rounded-sm shadow-lg relative">
                        <a href="{{ route('photos.show', $photo) }}">
                            <img 
                            src="{{ $photo->photo_url }}" 
                            alto="photo by {{ $photo->user->name }}" 
                            class="w-full h-full object-cover object-center absolute inset-0 group-hover:scale-105 transition duration-200"
                            />
                        </a>
                        </li>
                    @endforeach
                </ul>            
            @endif
        @endisset
    </div>

    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('clearSelection').addEventListener('click', function () {
                // ドロップダウンリストの選択値をクリア
                document.querySelectorAll('select').forEach(function (select) {
                    select.selectedIndex = 0;
                });
            });
        });
    </script>

    

</x-app-layout>

