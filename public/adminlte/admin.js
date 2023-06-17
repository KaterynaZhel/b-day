$(document).ready(function () {
    $(".nav-treeview .nav-link, .nav-link").each(function () {
        var location2 = window.location.protocol + '//' + window.location.host + window.location.pathname;
        var link = this.href;
        if (link == location2) {
            $(this).addClass('active');
            $(this).parent().parent().parent().addClass('menu-is-opening menu-open');

        }
    });

    $('.destroy-btn').click(function () {
        var res = confirm('Ви дійсно бажаєте видалити даного Іменинника з бази даних Компанії?');
        if (!res) {
            return false;
        }
    });
})