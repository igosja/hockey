jQuery(document).ready(function () {
    var element_id_filter = $('#filters');
    element_id_filter.find('input').on('change', function() {
        $(this).parents('form').submit();
    });
    element_id_filter.find('select').on('change', function() {
        $(this).parents('form').submit();
    });

    if ($('#admin-bell').length)
    {
        setInterval(function() {
            $.ajax({
                dataType: 'json',
                success: function (data) {
                    $('#admin-bell').html(data.bell);
                    $('#admin-support').html(data.support);
                    $('#admin-teamask').html(data.teamask);
                },
                url: '/admin/json/bell.php'
            });
        }, 30000);
    }
});