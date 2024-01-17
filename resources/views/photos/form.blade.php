
<option value="">選択してください</option>
        @foreach($colors as $color)
            <option value="{{ $color->id }}">{{ $color->name }}</option>
        @endforeach
