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
            var url = $('#physical-available').data('url');

            $.ajax({
                url: url + '?physicalId=' + physical_id + '&playerId=' + player_id + '&scheduleId=' + schedule_id,
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
        })
        .on('change', '#stadium-increase-input', function () {
            var stadiumIncreaseInput = $(this);
            var capacityNew = parseInt(stadiumIncreaseInput.val());
            var stadiumIncreaseSitPrice = stadiumIncreaseInput.data('sit_price');
            var url = stadiumIncreaseInput.data('url');

            var stadiumIncreaseCurrent = stadiumIncreaseInput.data('current');

            var price = getIncreasePrice(capacityNew, stadiumIncreaseCurrent, stadiumIncreaseSitPrice);

            $.ajax({
                url: url + '?value=' + price,
                dataType: 'json',
                success: function (data) {
                    $('#stadium-increase-price').html(data.value);
                }
            });
        })
        .on('change', '#stadium-decrease-input', function () {
            var stadiumDecreaseInput = $(this);
            var capacityNew = parseInt(stadiumDecreaseInput.val());
            var stadiumIncreaseSitPrice = stadiumDecreaseInput.data('sit_price');
            var url = stadiumDecreaseInput.data('url');

            var stadiumIncreaseCurrent = stadiumDecreaseInput.data('current');

            var price = getDecreasePrice(capacityNew, stadiumIncreaseCurrent, stadiumIncreaseSitPrice);

            $.ajax({
                url: url + '?value=' + price,
                dataType: 'json',
                success: function (data) {
                    $('#stadium-decrease-price').html(data.value);
                }
            });
        });
});

function getIncreasePrice(capacityNew, capacityCurrent, oneSitPrice) {
    return parseInt((Math.pow(capacityNew, 1.1) - Math.pow(capacityCurrent, 1.1)) * oneSitPrice);
}

function getDecreasePrice(capacityNew, capacityCurrent, oneSitPrice) {
    return parseInt((Math.pow(capacityCurrent, 1.1) - Math.pow(capacityNew, 1.1)) * oneSitPrice);
}