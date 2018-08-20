jQuery(document).ready(function () {
    $(document)
        .on('click', '.show-full-table', function () {
            $('.show-full-table').hide();
            var table_list = $('table');
            table_list.find('th').removeClass('hidden-xs');
            table_list.find('td').removeClass('hidden-xs');
        })
        .on('change', '#select-squad', function () {
            var line_id = $(this).val();
            var url = $(this).data('url');
            $.ajax({
                url: url + '?squad=' + line_id
            });
        })
        .on('click', '#btnTransferApplicationFrom', function () {
            $('#formTransferApplicationFrom').submit();
        });
});