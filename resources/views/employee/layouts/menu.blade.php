<div onclick="menu.toggle()" class="menu-button shadow-longer">
    <div id="_menu_badge__button" class="notification-menu-badge--button bg-purple color-white"></div>
    <div class="menu-button--line"></div>
    <div class="menu-button--line"></div>
    <div class="menu-button--line"></div>
</div>
<div id="_menu" class="menu">
    <div onclick="menu.toggle()" class="menu--close-button shadow-longer">x</div>
    <div class="menu--container">
        <div class="menu--container--title"></div>
        <a href="{{ route('employee.home') }}" class="menu--container--item--link">{{ __('employee/menu.items.home') }}</a>
        <a href="{{ route('employee.notifications.all') }}" class="menu--container--item--link">
            <span id="_menu_badge__item"></span>
            {{ __('employee/menu.items.notifications') }}
        </a>
        <a href="{{ route('employee.labels.all') }}" class="menu--container--item--link">{{ __('employee/menu.items.labels') }}</a>
        <a href="{{ route('employee.logout') }}" class="menu--container--item--link">{{ __('employee/menu.items.logout') }}</a>
        <div class="menu--container--item--select-label">{{ __('employee/menu.items.language') }}</div>
        <select onchange="menu.changeLocale(this)" class="menu--container--item--select-input shadow-light">
            @foreach ($__languages['all'] as $language_key => $language_value)
                <option value="{{ $language_key }}">{{ $language_value['nativeName'] }}</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    var menu = {
        dom_menu : "_menu",
        toggle : function() {
            if (document.getElementById(this.dom_menu).classList.contains('open')) {
                document.getElementById(this.dom_menu).classList.remove('open');
            } else {
                document.getElementById(this.dom_menu).classList.add('open');
            }
        },
        changeLocale : function(e) {
            var url = window.waiterbell_js_env.app_url + 'home';
            url += '?changeLocale=' + e.value;
            window.location.href = url;
        }
    };
    var menu_badge = {
        dom_menu_button : "_menu_badge__button",
        dom_menu_item : "_menu_badge__item",
        increment : function() {
            var value = parseInt(document.getElementById(this.dom_menu_button).innerHTML, 10);
            if (isNaN(value)) {
                value = 0;
            }
            value++;
            this.update_menu_button(value);
            this.update_menu_item(value);
        },
        update_menu_button : function(value) {
            document.getElementById(this.dom_menu_button).innerHTML = value;
        },
        update_menu_item : function(value) {
            document.getElementById(this.dom_menu_item).innerHTML = '(' + value + ')';
        },
    };
</script>