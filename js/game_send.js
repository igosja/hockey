jQuery(document).ready(function () {
    var position_array = '';
    var current = 0;

    for (var i=1; i<=5; i++)
    {
        if (1 == i)
        {
            current_1       = ld_1_id;
            current_2       = ld_2_id;
            current_3       = ld_3_id;
            position_array  = ld_array;
        }
        else if (2 == i)
        {
            current_1       = rd_1_id;
            current_2       = rd_2_id;
            current_3       = rd_3_id;
            position_array  = rd_array;
        }
        else if (3 == i)
        {
            current_1       = lw_1_id;
            current_2       = lw_2_id;
            current_3       = lw_3_id;
            position_array  = lw_array;
        }
        else if (4 == i)
        {
            current_1       = c_1_id;
            current_2       = c_2_id;
            current_3       = c_3_id;
            position_array  = c_array;
        }
        else if (5 == i)
        {
            current_1       = rw_1_id;
            current_2       = rw_2_id;
            current_3       = rw_3_id;
            position_array  = rw_array;
        }

        var select_html_1 = '<option value="0">-</option>';
        var select_html_2 = '<option value="0">-</option>';
        var select_html_3 = '<option value="0">-</option>';

        for (var j=0; j<position_array.length; j++)
        {
            if (position_array[j][0] == current_1)
            {
                select_html_1 = select_html_1 + '<option value="' + position_array[j][0] + '" selected>' + position_array[j][1] + '</option>';
            }
            else if (-1 == $.inArray(position_array[j][0], [current_2, current_3]))
            {
                select_html_1 = select_html_1 + '<option value="' + position_array[j][0] + '">' + position_array[j][1] + '</option>';
            }

            if (position_array[j][0] == current_2)
            {
                select_html_2 = select_html_2 + '<option value="' + position_array[j][0] + '" selected>' + position_array[j][1] + '</option>';
            }
            else if (-1 == $.inArray(position_array[j][0], [current_1, current_3]))
            {
                select_html_2 = select_html_2 + '<option value="' + position_array[j][0] + '">' + position_array[j][1] + '</option>';
            }

            if (position_array[j][0] == current_3)
            {
                select_html_3 = select_html_3 + '<option value="' + position_array[j][0] + '" selected>' + position_array[j][1] + '</option>';
            }
            else if (-1 == $.inArray(position_array[j][0], [current_1, current_2]))
            {
                select_html_3 = select_html_3 + '<option value="' + position_array[j][0] + '">' + position_array[j][1] + '</option>';
            }
        }

        $('#line-1-' + i).html(select_html_1);
        $('#line-2-' + i).html(select_html_2);
        $('#line-3-' + i).html(select_html_3);
    }

    $('.lineup-change').on('change', function() {
        var position    = $(this).data('position');
        var line        = $(this).data('line');
        var player_id   = $(this).val();

        var player_id_array =
        [
            parseInt($('#line-1-' + position).val()),
            parseInt($('#line-2-' + position).val()),
            parseInt($('#line-3-' + position).val())
        ];

        if      (1 == position) { position_array = ld_array; }
        else if (2 == position) { position_array = rd_array; }
        else if (3 == position) { position_array = lw_array; }
        else if (4 == position) { position_array =  c_array; }
        else if (5 == position) { position_array = rw_array; }

        for (var i=1; i<=3; i++)
        {

            var line_player_id = $('#line-' + i + '-' + position).val();

            var select_html = '<option value="0">-</option>';

            for (var j=0; j<position_array.length; j++)
            {
                if (position_array[j][0] == player_id)
                {
                    if (i == line)
                    {
                        select_html = select_html + '<option selected value="' + position_array[j][0] + '">' + position_array[j][1] + '</option>';
                    }
                }
                else
                {
                    if (position_array[j][0] == line_player_id)
                    {
                        select_html = select_html + '<option selected value="' + position_array[j][0] + '">' + position_array[j][1] + '</option>';
                    }
                    else
                    {
                        if (-1 == $.inArray(position_array[j][0], player_id_array))
                        {
                            select_html = select_html + '<option value="' + position_array[j][0] + '">' + position_array[j][1] + '</option>';
                        }
                    }
                }
            }

            $('#line-' + i + '-' + position).html(select_html);
        }
    })
});