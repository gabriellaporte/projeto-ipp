<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="{{ route('index') }}" class="app-brand-link">
      <span class="app-brand-logo demo">
        @include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])
      </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->routeIs('index') ? 'active' : '' }}">
            <a href="{{ route('index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Página Inicial</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Minhas Informações</span>
        </li>

        <li class="menu-item {{ request()->routeIs('account.settings') || request()->routeIs('account.notifications.settings') ? 'active open' : '' }}">
            <a class="menu-link menu-toggle cursor-pointer">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div>Minha Conta</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('account.settings') ? 'active' : '' }}">
                    <a href="{{ route('account.settings') }}" class="menu-link">
                        <div>Config. de Perfil</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('account.notifications.settings') ? 'active' : '' }}">
                    <a href="{{ route('account.notifications.settings') }}" class="menu-link">
                        <div>Config. de Notificações</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->routeIs('account.notifications.settings') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell"></i>
                <div>Notificações</div>
            </a>
        </li>


        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Membros</span>
        </li>

        <li class="menu-item {{ request()->routeIs('birthdays') ? 'active' : '' }}">
            <a href="{{ route('birthdays') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cake"></i>
                <div>Aniversários</div>
            </a>
        </li>

        @hasrole('Oficial')
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Oficiais</span>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <a href="{{ route('admin.users') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Membros</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.notifications') ? 'active' : '' }}">
            <a href="{{ route('admin.notifications') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell-plus"></i>
                <div>Notificações</div>
            </a>
        </li>
        @endhasrole
    </ul>

</aside>
