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
                :permissions="['categories_view']"
                text="{{ trans('general.menus.management') }}" 
                iconClass="flaticon-piggy-bank"
                :activeClass="
                    Route::is('management.*')
                    ? 'm-menu__item--expanded m-menu__item--open' : ''"
            >
                <x-sub-menu-item 
                :permissions="['categories_view']"
                link="{{ route('management.categories.index') }}" 
                text="{{ trans('general.categories.title') }}" 
                :activeClass="Route::is('management.categories.*') ? 'm-menu__item--active' : ''"
            />
            </x-menu-item>

            <x-menu-item 
                :permissions="['roles_view', 'users_view']"
                text="{{ trans('general.menus.settings') }}" 
                iconClass="flaticon-settings"
                :activeClass="
                    Route::is('settings.*')
                    ? 'm-menu__item--expanded m-menu__item--open' : ''"
            >
                <x-sub-menu-item 
                    :permissions="['general_view']"
                    link="{{ route('settings.general.get') }}" 
                    text="{{ trans('general.settings.general.title') }}" 
                    :activeClass="Route::is('settings.general.*') ? 'm-menu__item--active' : ''"
                />
                <x-sub-menu-item 
                    :permissions="['email_view']"
                    link="{{ route('settings.email.get') }}" 
                    text="{{ trans('general.settings.email.title') }}" 
                    :activeClass="Route::is('settings.email.*') ? 'm-menu__item--active' : ''"
                />
                <x-sub-menu-item 
                    :permissions="['api_view']"
                    link="{{ route('settings.api.get') }}" 
                    text="{{ trans('general.settings.api.title') }}" 
                    :activeClass="Route::is('settings.api.*') ? 'm-menu__item--active' : ''"
                />
            </x-menu-item>

            <x-menu-item 
                :permissions="['roles_view', 'users_view', 'logs_view']"
                text="{{ trans('general.menus.platform_administration') }}" 
                iconClass="flaticon-interface-7" 
                :activeClass="
                    Route::is('system.*')
                    ? 'm-menu__item--expanded m-menu__item--open' : ''"
            >
                <x-sub-menu-item 
                    :permissions="['roles_view']"
                    link="{{ route('system.roles.index') }}" 
                    text="{{ trans('general.roles_and_permissions.title') }}" 
                    :activeClass="Route::is('system.roles.*') ? 'm-menu__item--active' : ''"
                />
                <x-sub-menu-item 
                    :permissions="['users_view']"
                    link="{{ route('system.users.index') }}" 
                    text="{{ trans('general.users.title') }}" 
                    :activeClass="Route::is('system.users.*') ? 'm-menu__item--active' : ''"
                />
                <x-sub-menu-item 
                    :permissions="['logs_view']"
                    link="{{ route('system.logs.index') }}" 
                    text="{{ trans('general.logs.title') }}" 
                    :activeClass="Route::is('system.logs.*') ? 'm-menu__item--active' : ''"
                />
                <x-sub-menu-item link="javascript:;" text="Backups"/>
            </x-menu-item>
        </ul>
    </div>

    <!-- END: Aside Menu -->
</div>

<!-- END: Left Aside -->