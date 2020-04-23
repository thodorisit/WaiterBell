@if (View::hasSection('filters_content'))
    <div onclick="filters.toggle()" class="filters-icon shadow-longer">
        <svg class="filters-icon--svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M9.664 15l-8.664-15h22l-8.703 15h-4.633zm2.336 2c-1.407 2.099-2.312 3.412-2.312 4.688 0 1.277 1.035 2.312 2.312 2.312s2.312-1.035 2.312-2.312c0-1.276-.905-2.589-2.312-4.688zm.159 3.007c-.333.833-1.266.622-.765-.465.211-.458.357-.652.598-1.049.198.311.389.959.167 1.514z"/>
        </svg>
    </div>
    <div id="_filters" class="filters">
        <div onclick="filters.toggle()" class="filters--close-button shadow-longer">x</div>
        <div class="filters--container">
            @yield('filters_content')
        </div>
    </div>
@endif

<script>
    var filters = {
        dom_menu : "_filters",
        toggle : function() {
            if (document.getElementById(this.dom_menu).classList.contains('open')) {
                document.getElementById(this.dom_menu).classList.remove('open');
            } else {
                document.getElementById(this.dom_menu).classList.add('open');
            }
        }
    };
</script>