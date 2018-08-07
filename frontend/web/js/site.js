jQuery(document).ready(function () {
    $('.show-full-table').on('click', function () {
        $('.show-full-table').hide();
        var table_list = $('table');
        table_list.find('th').removeClass('hidden-xs');
        table_list.find('td').removeClass('hidden-xs');
    });

    $('#select-squad').on('change', function () {
        var line_id = $(this).val();
        var player_id = $(this).data('player');
        $.ajax({
            url: '/player/squad/' + player_id + '?squad=' + line_id
        });
        return false;
    });
});