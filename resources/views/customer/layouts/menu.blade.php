<div onclick="menu.toggle()" class="menu-button shadow-longer">
    <div class="menu-button--line"></div>
    <div class="menu-button--line"></div>
    <div class="menu-button--line"></div>
</div>
<div id="_menu" class="menu">
    <div onclick="menu.toggle()" class="menu--close-button shadow-longer">x</div>
    <div class="menu--container">
        <div class="menu--container--title">{{ $translations['customer.home.choose_language'] }}</div>
        <form class="menu--container--choose-language-form">
            @php ($current_language = session('customer_language'))
            <select onchange="menu.changeLocale(this)" class="menu--container--choose-language-form--select-input shadow-light">
                @foreach ($languages as $key => $value)
                    <option value="{{ $value['slug'] }}" {{ $current_language == $value['slug'] ? 'selected' : "" }}>{{ $value['native_name'] }}</option>
                @endforeach
            </select>
            @include('customer.layouts.footer')
        </form>
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
            url += '?label_id='+window.waiterbell_js_env.label_id;
            url += '&changeLocale=' + e.value;
            window.location.href = url;
        }
    };
</script>