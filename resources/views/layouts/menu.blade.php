<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            
            <x-menu-single 
                :permissions="['dashboard_view']"
                text="{{ trans('general.menus.dashboard') }}"
                link="{{ route('dashboard.index') }}"
                iconClass="flaticon-line-graph"
                :activeClass="
                    Route::is('dashboard.*')
                    ? 'm-menu__item--expanded' : ''"
            />

            <x-menu-item 
                text="{{ trans('general.menus.settings') }}" 
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
                :permissions="['roles_view', 'users_view']"
                text="{{ trans('general.menus.platform_administration') }}" 
                iconClass="flaticon-interface-7" 
                :activeClass="
                    Route::is('users.*') ||
                    Route::is('roles.*')
                    ? 'm-menu__item--expanded m-menu__item--open' : ''"
            >
                <x-sub-menu-item 
                    :permissions="['roles_view']"
                    link="{{ route('roles.index') }}" 
                    text="{{ trans('general.roles_and_permissions.title') }}" 
                    :activeClass="Route::is('roles.*') ? 'm-menu__item--active' : ''"
                />
                <x-sub-menu-item 
                    :permissions="['users_view']"
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