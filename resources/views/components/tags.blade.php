@if (!empty($items))
    @foreach ($items as $item)
        <span class="m-badge m-badge--accent m-badge--wide">{{ $item->name }}</span>
    @endforeach
@else
    <span>_</span>
@endif