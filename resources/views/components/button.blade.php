<button type="{{ $type }}" 
        @if($isDisabled) disabled @endif 
        class="btn {{ $class }}"
        {{ $attributes }}
        >
    {{ $label }}
</button>
