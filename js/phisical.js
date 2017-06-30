jQuery(document).ready(function () {
    $('.phisical-change-cell').on('click', function() {
        var phisical_id = $(this).data('phisical');
        var player_id   = $(this).data('player');
        var shedule_id  = $(this).data('shedule');

        $.ajax({
            url: '/json.php?phisical_id=' + phisical_id + '&player_id=' + player_id + '&shedule_id=' + shedule_id,
            dataType: 'json',
            success: function (data)
            {
                console.log(data);
                for (var i=0; i<data['list'].length; i++)
                {
                    var list_id = $('#' + data['list'][i].id);
                    list_id.removeClass(data['list'][i].remove_class_1);
                    list_id.removeClass(data['list'][i].remove_class_2);
                    list_id.addClass(data['list'][i].class);
                    list_id.data('phisical', data['list'][i].phisical_id);
                    list_id.html(
                        '<img src="/img/phisical/'
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