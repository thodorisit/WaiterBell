<div class="topbar shadow-light">
    <img src="{{ url('business-logo').'/' }}@yield('info__business_logo_url')" class="topbar--business-logo" alt="logo"/>
    <div class="topbar--business-name">@yield('info__business_name')</div>
    <div class="topbar--info">
        <div class="topbar--info--label">@yield('info__label_seat')</div>
        <div class="topbar--info--id">@yield('info__label_name')</div>
    </div>
</div>