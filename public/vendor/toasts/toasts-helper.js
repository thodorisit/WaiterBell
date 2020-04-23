var ToastJS = {
    close : function(id) {
        document.getElementById('toast_item_'+id).classList.remove('show');
        document.getElementById('toast_item_'+id).classList.add('d-none');
    },
    autoHide : function() {
        setTimeout(function(){
            var toasts_items = document.getElementsByClassName('toast-autohide');
            for (var i=0; i<toasts_items.length; i++) {
                toasts_items[i].classList.remove('show');
                toasts_items[i].classList.add('d-none');
            }
        }, 20000);
    },
    startHideTimeout : function(id) {
        setTimeout(function(){
            var toasts_items = document.getElementsByClassName('toast-hide-'+id);
            for (var i=0; i<toasts_items.length; i++) {
                toasts_items[i].classList.remove('show');
                toasts_items[i].classList.add('d-none');
            }
        }, 20000);
    },
    dom_toasts_container : "__toasts_container",
    types : {
        'success' : {
            'svg' : '<svg width="20" height="20" class="mr-2" viewBox="0 0 24 24"><path fill="#28a745" d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M11,16.5L18,9.5L16.59,8.09L11,13.67L7.91,10.59L6.5,12L11,16.5Z"></path></svg>',
        },
        'warning' : {
            'svg' : '<svg width="25" height="25" class="mr-2" viewBox="0 0 24 18"><path fill="#f9c513" d="M8.893 1.5c-.183-.31-.52-.5-.887-.5s-.703.19-.886.5L.138 13.499a.98.98 0 0 0 0 1.001c.193.31.53.501.886.501h13.964c.367 0 .704-.19.877-.5a1.03 1.03 0 0 0 .01-1.002L8.893 1.5zm.133 11.497H6.987v-2.003h2.039v2.003zm0-3.004H6.987V5.987h2.039v4.006z"/></svg>',
        },
        'error' : {
            'svg' : '<svg width="25" height="25" class="mr-2" viewBox="0 0 24 18"><path fill="#e74a3b" d="M8.893 1.5c-.183-.31-.52-.5-.887-.5s-.703.19-.886.5L.138 13.499a.98.98 0 0 0 0 1.001c.193.31.53.501.886.501h13.964c.367 0 .704-.19.877-.5a1.03 1.03 0 0 0 .01-1.002L8.893 1.5zm.133 11.497H6.987v-2.003h2.039v2.003zm0-3.004H6.987V5.987h2.039v4.006z"/></svg>',
        }
    },
    create : function(type, title, body) {
        var template_html = this.template(type, title, body);
        this.put(template_html);
    },
    template : function(type, title, body) {
        var toast_id = Date.now();
        this.startHideTimeout(toast_id);
        var html = "";
        html += '<div id="toast_item_'+toast_id+'" role="alert" class="toast toast-hide-'+toast_id+' show">'
                + '<div class="toast-header">'
                    + this.types[type].svg
                    + '<strong class="mr-auto">'+title+'</strong>'
                    + '<small></small>'
                    + '<button onClick="ToastJS.close('+toast_id+')" type="button" class="ml-2 mb-1 close">'
                        + '<span>&times;</span>'
                    + '</button>'
                + '</div>'
            + '<div class="toast-body">'
                + body
            + '</div>'
        + '</div>';
        return html;
    },
    put : function(res) {
        document.getElementById(this.dom_toasts_container).innerHTML = res + document.getElementById(this.dom_toasts_container).innerHTML;
    }
};