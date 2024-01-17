<x-app-layout>
<!DOCTYPE html>

<html lang='en'>
  <head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          events: [
                    // PHPで生成したJSONデータをここに挿入
                    @foreach ($photos as $photo)
                    {
                        title: '',
                        start: '{{ $photo->selected_date }}',
                        image: '{{ $photo->photo_url }}',
                        url: '{{ route('photos.show', $photo) }}',
                        display: 'background' // 背景として画像を表示
                    },
                    @endforeach
                ],
                eventDidMount: function(info) {
                    // 写真をイベントの背景画像として表示
                    if (info.event.extendedProps.image) {
                        info.el.style.backgroundImage = 'url(' + info.event.extendedProps.image + ')';
                        info.el.classList.add('photo-event'); // カスタムクラスを追加
                    }
                },
                eventClick: function(info) {
                    //クリックすると写真の詳細ページへ移動
                    info.jsEvent.preventDefault(); // デフォルトのイベントをキャンセル
                    window.open(info.event.url); // 新しいタブでURLを開く
                }
            });
        calendar.render();
      });

    </script>

    <style>
        .photo-event {
            background-size: cover !important; /* 画像が枠内に収まるように調整 */
            background-position: center; /* 画像を中央に配置 */
            opacity: 1 !important; /*画像の透過度を0に */
        }
    </style>
  </head>


  <body class="dark:text-white">
    <div id='calendar'></div>
  </body>
</html>

</x-app-layout>