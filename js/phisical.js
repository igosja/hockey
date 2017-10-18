jQuery(document).ready(function () {
    $('.phisical-change-cell').on('click', function() {
        var phisical_id = $(this).data('phisical');
        var player_id   = $(this).data('player');
        var schedule_id  = $(this).data('schedule');

        $.ajax({
            url: '/json/phisical.php?phisical_id=' + phisical_id + '&player_id=' + player_id + '&schedule_id=' + schedule_id,
            dataType: 'json',
            success: function (data)
            {
                for (var i=0; i<data['list'].length; i++)
                {
                    var list_id = $('#' + data['list'][i].id);
                    list_id.removeClass(data['list'][i].remove_class_1);
                    list_id.removeClass(data['list'][i].remove_class_2);
                    list_id.addClass(data['list'][i].class);
                    list_id.data('phisical', data['list'][i].phisical_id);
                    list_id.html(
                        '<img alt="'
                        + data['list'][i].phisical_value
                        + '%" src="/img/phisical/'
                        + data['list'][i].phisical_id
                        + '.png" title="'
                        + data['list'][i].phisical_value
                        + '%">'
                    );
                }

                $('#phisical-available').html(data['available']);
            }
        });
    });
});