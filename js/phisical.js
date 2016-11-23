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
                for (var i=0; i<data.length; i++)
                {
                    $('#' + data[i].id).removeClass(data[i].remove_class_1);
                    $('#' + data[i].id).removeClass(data[i].remove_class_2);
                    $('#' + data[i].id).addClass(data[i].class);
                    $('#' + data[i].id).data('phisical', data[i].phisical_id);
                    $('#' + data[i].id).html(
                        '<img src="/img/phisical/'
                        + data[i].phisical_id
                        + '.png" title="'
                        + data[i].phisical_value
                        + '">'
                    );
                }
            }
        });
    });
});