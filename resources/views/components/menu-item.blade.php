<li class="m-menu__item m-menu__item--submenu {{ $activeClass }}"  aria-haspopup="true" m-menu-submenu-toggle="hover">
    <a href="javascript:;" class="m-menu__link m-menu__toggle">
        <i class="m-menu__link-icon {{ $iconClass }}"></i>
        <span class="m-menu__link-text">{{ $text }}</span>
        <i class="m-menu__ver-arrow la la-angle-right"></i>
    </a>
    <div class="m-menu__submenu">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
            {{ $slot }}
        </ul>
    </div>
</li>
