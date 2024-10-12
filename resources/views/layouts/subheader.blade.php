<div class="m-subheader">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">{{ $title }}</h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="#" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                @foreach ($breadcrumbs as $breadcrumb)
                    <li class="m-nav__item {{ $loop->first ? 'm-nav__item--home' : '' }}">
                        <a href="{{ $breadcrumb['url'] }}" class="m-nav__link">
                            <span class="m-nav__link-text">{{ $breadcrumb['text'] }}</span>
                        </a>
                    </li>
                    @if (!$loop->last)
                        <li class="m-nav__separator">-</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>