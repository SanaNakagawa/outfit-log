<x-app-layout>
    <div class="container mx-auto text-center p-4">
        <section>
            <h2 class="text-2xl font-semibold mb-4  dark:text-white">OUTFIT LOG</h2>
            <div class="mb-8  dark:text-white">
                <p>「去年の今頃なに着てたっけ？」</p>
                <p>「あれ、先週もこれ着てあの人に会ったっけ？」</p>
                <p>「このセーターになに合わせてたかな？」</p>
            </div>

            <p class=" dark:text-white">こんな悩みを解決するために作成しました</p>
            
            
            <!--  -->
            <div class="bg-white rounded-lg p-6 shadow-lg my-6">
                <h3 class="font-semibold mb-2">簡単に投稿</h3>
                <p>写真を撮ったらアイテムのカテゴリ・色を選択してアップロード。すでに投稿したコーディネートを詳細ページから再登録も可能です。他のユーザーに写真を見られることはありません。</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-6">
                <!-- 一覧ページ -->
                <div class="bg-white rounded-lg p-6 shadow-lg">
                    <h3 class="font-semibold mb-2">ホーム</h3>
                    <p>当日の気温と前日との差が表示されます。これまでに登録したコーディネートの写真を全て閲覧できます。</p>
                    
                </div>

                <!-- 詳細ページ -->
                <div class="bg-white rounded-lg p-6 shadow-lg">
                    <h3 class="font-semibold mb-2">詳細ページ</h3>
                    <p>登録したコーディネートの詳細を表示。登録日の気温、選択したアイテム、似たアイテムを使用した他のコーディネートも表示されます。その服装が適切だったかの評価、コメントできます。</p>
                </div>

                <!-- 検索ページ -->
                <div class="bg-white rounded-lg p-6 shadow-lg">
                    <h3 class="font-semibold mb-2">検索ページ</h3>
                    <p>アイテムのカテゴリ・色を選んで過去に投稿したコーディネートを検索できます。</p>
                </div>

                <!-- カレンダー表示 -->
                <div class="bg-white rounded-lg p-6 shadow-lg">
                    <h3 class="font-semibold mb-2">カレンダー表示</h3>
                    <p>これまでに投稿した写真をカレンダー上に表示。曜日ごとに何を着たか一目でわかります。</p>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 shadow-lg my-6 text-center">
                <h3 class="font-semibold mb-2"></h3>
                <p>自分だけのOutfit Logを作りましょう&#9834</p>
            </div>

        </section>
    </div>
</x-app-layout>
