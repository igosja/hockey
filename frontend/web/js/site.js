jQuery(document).ready(function () {
    $('.show-full-table').on('click', function () {
        $('.show-full-table').hide();
        var table_list = $('table');
        table_list.find('th').removeClass('hidden-xs');
        table_list.find('td').removeClass('hidden-xs');
    });
});