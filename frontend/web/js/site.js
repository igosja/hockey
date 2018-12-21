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
        })
        .on('click', '#btnLoanApplicationFrom', function () {
            $('#formLoanApplicationFrom').submit();
        })
        .on('change', '.submit-on-change', function () {
            $(this).closest('form').submit();
        })
        .on('click', '.physical-change-cell', function () {
            var physical_id = $(this).data('physical');
            var player_id = $(this).data('player');
            var schedule_id = $(this).data('schedule');

            $.ajax({
                url: '/json/physical.php?physical_id=' + physical_id + '&player_id=' + player_id + '&schedule_id=' + schedule_id,
                dataType: 'json',
                success: function (data) {
                    for (var i = 0; i < data['list'].length; i++) {
                        var list_id = $('#' + data['list'][i].id);
                        list_id.removeClass(data['list'][i].remove_class_1);
                        list_id.removeClass(data['list'][i].remove_class_2);
                        list_id.addClass(data['list'][i].class);
                        list_id.data('physical', data['list'][i].physical_id);
                        list_id.html(
                            '<img alt="'
                            + data['list'][i].physical_name
                            + '%" src="/img/physical/'
                            + data['list'][i].physical_id
                            + '.png" title="'
                            + data['list'][i].physical_name
                            + '%">'
                        );
                    }

                    $('#physical-available').html(data['available']);
                }
            });
        });
});