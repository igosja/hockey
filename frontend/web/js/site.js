jQuery(document).ready(function () {
    $(document)
        .on('click', '.show-full-table', function () {
            $('.show-full-table').hide();
            let table_list = $('table');
            table_list.find('th').removeClass('hidden-xs');
            table_list.find('td').removeClass('hidden-xs');
        })
        .on('change', '#select-squad', function () {
            let line_id = $(this).val();
            let url = $(this).data('url');
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
            let physical_id = $(this).data('physical');
            let player_id = $(this).data('player');
            let schedule_id = $(this).data('schedule');
            let url = $('#physical-available').data('url');

            $.ajax({
                url: url + '?physicalId=' + physical_id + '&playerId=' + player_id + '&scheduleId=' + schedule_id,
                dataType: 'json',
                success: function (data) {
                    for (let i = 0; i < data['list'].length; i++) {
                        let list_id = $('#' + data['list'][i].id);
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