<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item " aria-haspopup="true"><a href="index.html" class="m-menu__link "><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap"> <span class="m-menu__link-text">Dashboard</span>
                            <span class="m-menu__link-badge"><span class="m-badge m-badge--danger">2</span></span> </span></span></a></li>
            <li class="m-menu__section ">
                <h4 class="m-menu__section-text">CRUD</h4>
                <i class="m-menu__section-icon flaticon-more-v2"></i>
            </li>
            <x-menu-item 
                title="{{ trans('general.menus.settings') }}" 
                iconClass="flaticon-settings"
            >
                <x-sub-menu-item link="components/base/state.html" text="General"/>
                <x-sub-menu-item link="components/base/typography.html" text="Email"/>
                <x-sub-menu-item link="components/base/stack.html" text="Language"/>
                <x-sub-menu-item link="components/base/stack.html" text="Media"/>
                <x-sub-menu-item link="components/base/stack.html" text="Pemarlink"/>
                <x-sub-menu-item link="components/base/stack.html" text="Cronjob"/>
                <x-sub-menu-item link="components/base/stack.html" text="API Settings"/>
            </x-menu-item>

            <x-menu-item 
                title="{{ trans('general.menus.platform_administration') }}" 
                iconClass="flaticon-interface-7" 
                :activeClass="
                    Route::is('users.*') ||
                    Route::is('roles.*')
                    ? 'm-menu__item--expanded m-menu__item--open' : ''"
            >
                <x-sub-menu-item 
                    link="{{ route('roles.index') }}" 
                    text="{{ trans('general.roles_and_permissions.title') }}" 
                    :activeClass="Route::is('roles.*') ? 'm-menu__item--active' : ''"
                />
                <x-sub-menu-item 
                    link="{{ route('users.index') }}" 
                    text="{{ trans('general.users.title') }}" 
                    :activeClass="Route::is('users.*') ? 'm-menu__item--active' : ''"
                />
                <x-sub-menu-item link="components/base/stack.html" text="Activities Logs"/>
                <x-sub-menu-item link="components/base/stack.html" text="Backups"/>
            </x-menu-item>
        </ul>
    </div>

    <!-- END: Aside Menu -->
</div>

<!-- END: Left Aside -->