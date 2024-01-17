
@props(['id', 'name', 'items', 'sessionDataKey', 'sessionData'])

<div>
    
    <select name="{{ $id }}" class="rounded-sm">
        @if( !isset($sessionData[$sessionDataKey]) || $sessionData[$sessionDataKey] === null)
            <option value="">選択してください</option>
        @endif
        @foreach($items as $item)
            <option value="{{ $item->id }}" {{ isset($sessionData[$sessionDataKey]) && $sessionData[$sessionDataKey]->id === $item->id ? 'selected' : ''}}>
                {{ $item->name }}
            </option>
        @endforeach
    </select>
</div>
