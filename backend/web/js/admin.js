jQuery(document).ready(function () {
    admin_bell();

    if ($('#admin-bell').length) {
        setInterval(function () {
            admin_bell();
        }, 30000);
    }
});

function admin_bell() {
    $.ajax({
        dataType: 'json',
        success: function (data) {
            $('#admin-bell').html(data.bell);
            if (data.bell > 0) {
                $('title').text('(' + data.bell + ') Admin');
            } else {
                $('title').text('Admin');
            }

            $('.admin-support').html(data.support);
            if (data.support > 0) {
                $('.panel-support').show();
            } else {
                $('.panel-support').hide();
            }

            $('.admin-vote').html(data.vote);
            if (data.vote > 0) {
                $('.panel-vote').show();
            } else {
                $('.panel-vote').hide();
            }

            $('.admin-logo').html(data.logo);
            if (data.logo > 0) {
                $('.panel-logo').show();
            } else {
                $('.panel-logo').hide();
            }

            $('.admin-complaint').html(data.complaint);
            if (data.complain > 0) {
                $('.panel-complaint').show();
            } else {
                $('.panel-complaint').hide();
            }

            $('.admin-freeTeam').html(data.freeTeam);
        },
        url: $('#admin-bell').data('url')
    });
}