<li class="m-menu__item {{ $activeClass }}"  aria-haspopup="true">
    <a href="{{ $link }}" class="m-menu__link ">
        <i class="m-menu__link-icon {{ $iconClass }}"></i>
        <span class="m-menu__link-title"> 
            <span class="m-menu__link-wrap"> 
                <span class="m-menu__link-text">{{ $text }}</span>
                {{-- <span class="m-menu__link-badge">
                    <span class="m-badge m-badge--danger">2</span>
                </span>  --}}
            </span>
        </span>
    </a>
</li>