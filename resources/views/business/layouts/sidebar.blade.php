<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('business.home') }}">
        <div class="d-md-none">
            <img class="sidebar-logo-horizontal" src="{{ url('/img/logo/logo-vertical.png') }}" alt="logo"/>
        </div>
        <div class="sidebar-brand-text mx-3 d-md-block">
            <img class="sidebar-logo-horizontal" src="{{ url('/img/logo/logo-horizontal.png') }}" alt="logo"/>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $__sidebar_menu_item_current == "home" ? "active" : ""  }}">
        <a class="nav-link" href="{{ route('business.home') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>{{ __('business/sidebar.item_homepage') }}</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        
    </div>
    
    <li class="nav-item {{ $__sidebar_menu_item_current == "notifications" || $__sidebar_menu_item_current == "request_types" ? "active" : ""  }}">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#notificationsSidebar">
            <i class="fas fa-fw fa-exclamation"></i>
            <span>{{ __('business/sidebar.item_notifications') }}</span>
        </a>
        <div id="notificationsSidebar" class="collapse">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('business.notifications.all') }}">
                    {{ __('business/sidebar.item_notifications__notifications_all') }}
                </a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">{{ __('business/sidebar.item_notifications__requests_types') }}</h6>
                <a class="collapse-item" href="{{ route('business.request_types.all') }}">
                    {{ __('business/sidebar.item_notifications__requests') }}
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ $__sidebar_menu_item_current == "employees" ? "active" : ""  }}">
        <a class="nav-link" href="{{ route('business.employees.all') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>{{ __('business/sidebar.item_employees') }}</span>
        </a>
    </li>

    <li class="nav-item {{ $__sidebar_menu_item_current == "labels" ? "active" : ""  }}">
        <a class="nav-link" href="{{ route('business.labels.all') }}">
            <i class="fas fa-fw fa-tags"></i>
            <span>{{ __('business/sidebar.item_labels') }}</span>
        </a>
    </li>

    <li class="nav-item {{ $__sidebar_menu_item_current == "connect_labels_employees" ? "active" : ""  }}">
        <a class="nav-link" href="{{ route('business.connect_labels_employees.init') }}">
            <i class="fas fa-fw fa-sitemap"></i>
            <span>{{ __('business/sidebar.item_connect_labels_employees') }}</span>
        </a>
    </li>
    
    <li class="nav-item {{ $__sidebar_menu_item_current == "languages" || $__sidebar_menu_item_current == "translations" ? "active" : ""  }}">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#languagesSidebar">
            <i class="fas fa-fw fa-language"></i>
            <span>{{ __('business/sidebar.item_languages') }}</span>
        </a>
        <div id="languagesSidebar" class="collapse">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('business.languages.all') }}">
                    {{ __('business/sidebar.item_languages__languages') }}
                </a>
                <div class="collapse-divider"></div>
                <a class="collapse-item" href="{{ route('business.translations.all') }}">
                    {{ __('business/sidebar.item_languages__translations') }}
                </a>
            </div>
        </div>
    </li>

</ul>
<!-- End of Sidebar -->