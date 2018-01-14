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
            $('.admin-bell').html(data.bell);
            $('.admin-support').html(data.support);
            $('.admin-teamask').html(data.teamask);
            $('.admin-vote').html(data.vote);
            if (data.bell > 0) {
                $('title').text('(' + data.bell + ') Административный раздел');
            }
            if (data.support > 0) {
                $('.panel-support').show();
            }
            if (data.teamask > 0) {
                $('.panel-teamask').show();
            }
            if (data.vote > 0) {
                $('.panel-vote').show();
            }
        },
        url: '/admin/json/bell.php'
    });
}