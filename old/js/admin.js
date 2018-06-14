jQuery(document).ready(function () {
    var element_id_filter = $('#filters');
    element_id_filter.find('input').on('change', function() {
        $(this).parents('form').submit();
    });
    element_id_filter.find('select').on('change', function() {
        $(this).parents('form').submit();
    });

    admin_bell();

    if ($('#admin-bell').length)
    {
        setInterval(function() { admin_bell(); }, 30000);
    }
});

function admin_bell()
{
    $.ajax({
        dataType: 'json',
        success: function (data) {
            $('#admin-bell').html(data.bell);
            if (data.bell > 0) {
                $('title').text('(' + data.bell + ') Административный раздел');
            } else {
                $('title').text('Административный раздел');
            }

            $('.admin-support').html(data.support);
            if (data.support > 0) {
                $('.panel-support').show();
            } else {
                $('.panel-support').hide();
            }

            $('.admin-teamask').html(data.teamask);
            if (data.teamask > 0) {
                $('.panel-teamask').show();
            } else {
                $('.panel-teamask').hide();
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

            $('.admin-complain').html(data.complain);
            if (data.complain > 0) {
                $('.panel-complain').show();
            } else {
                $('.panel-complain').hide();
            }

            $('.admin-freeteam').html(data.freeteam);
        },
        url: '/admin/json/bell.php'
    });
}