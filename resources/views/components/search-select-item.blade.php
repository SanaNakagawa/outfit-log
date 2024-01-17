@props(['id', 'name', 'items', 'selectedItem'])

<div>
    
    <select name="{{ $id }}" class="rounded-sm">
        <option value="">選択してください</option>
        @foreach ($items as $item)
            <option value="{{ $item->id }}" {{ $item->id == old($id, $selectedItem) ? 'selected' : '' }}>{{ $item->name }}</option>
        @endforeach
    </select>
</div>