jQuery(document).ready(function () {
    var grid = $('#grid');
    var grid_th = grid.find('thead').find('th');
    grid_th.on('click', function() {
        sort_grid(grid, $(this).data('type'), $.inArray(this, grid_th));
    });

    var position_array = '';
    var current_1;
    var current_2;
    var current_3;
    var other_1;
    var other_2;
    var other_3;
    var promt;

    for (var i=1; i<=5; i++)
    {
        if (1 === i)
        {
            current_1       = ld_1_id;
            other_1         = [ld_2_id, ld_3_id, rd_1_id, rd_2_id, rd_3_id, lw_1_id, lw_2_id, lw_3_id, c_1_id, c_2_id, c_3_id, rw_1_id, rw_2_id, rw_3_id];
            current_2       = ld_2_id;
            other_2         = [ld_1_id, ld_3_id, rd_1_id, rd_2_id, rd_3_id, lw_1_id, lw_2_id, lw_3_id, c_1_id, c_2_id, c_3_id, rw_1_id, rw_2_id, rw_3_id];
            current_3       = ld_3_id;
            other_3         = [ld_1_id, ld_2_id, rd_1_id, rd_2_id, rd_3_id, lw_1_id, lw_2_id, lw_3_id, c_1_id, c_2_id, c_3_id, rw_1_id, rw_2_id, rw_3_id];
            position_array  = ld_array;
            promt           = 'LD -';
        }
        else if (2 === i)
        {
            current_1       = rd_1_id;
            other_1         = [ld_1_id, ld_2_id, ld_3_id, rd_2_id, rd_3_id, lw_1_id, lw_2_id, lw_3_id, c_1_id, c_2_id, c_3_id, rw_1_id, rw_2_id, rw_3_id];
            current_2       = rd_2_id;
            other_2         = [ld_1_id, ld_2_id, ld_3_id, rd_1_id, rd_3_id, lw_1_id, lw_2_id, lw_3_id, c_1_id, c_2_id, c_3_id, rw_1_id, rw_2_id, rw_3_id];
            current_3       = rd_3_id;
            other_3         = [ld_1_id, ld_2_id, ld_3_id, rd_1_id, rd_2_id, lw_1_id, lw_2_id, lw_3_id, c_1_id, c_2_id, c_3_id, rw_1_id, rw_2_id, rw_3_id];
            position_array  = rd_array;
            promt           = 'RD -';
        }
        else if (3 === i)
        {
            current_1       = lw_1_id;
            other_3         = [ld_1_id, ld_2_id, ld_3_id, rd_1_id, rd_2_id, rd_3_id, lw_2_id, lw_3_id, c_1_id, c_2_id, c_3_id, rw_1_id, rw_2_id, rw_3_id];
            current_2       = lw_2_id;
            other_3         = [ld_1_id, ld_2_id, ld_3_id, rd_1_id, rd_2_id, rd_3_id, lw_1_id, lw_3_id, c_1_id, c_2_id, c_3_id, rw_1_id, rw_2_id, rw_3_id];
            current_3       = lw_3_id;
            other_3         = [ld_1_id, ld_2_id, ld_3_id, rd_1_id, rd_2_id, rd_3_id, lw_1_id, lw_2_id, c_1_id, c_2_id, c_3_id, rw_1_id, rw_2_id, rw_3_id];
            position_array  = lw_array;
            promt           = 'LW -';
        }
        else if (4 === i)
        {
            current_1       = c_1_id;
            other_3         = [ld_1_id, ld_2_id, ld_3_id, rd_1_id, rd_2_id, rd_3_id, lw_1_id, lw_2_id, lw_3_id, c_2_id, c_3_id, rw_1_id, rw_2_id, rw_3_id];
            current_2       = c_2_id;
            other_3         = [ld_1_id, ld_2_id, ld_3_id, rd_1_id, rd_2_id, rd_3_id, lw_1_id, lw_2_id, lw_3_id, c_1_id, c_3_id, rw_1_id, rw_2_id, rw_3_id];
            current_3       = c_3_id;
            other_3         = [ld_1_id, ld_2_id, ld_3_id, rd_1_id, rd_2_id, rd_3_id, lw_1_id, lw_2_id, lw_3_id, c_1_id, c_2_id, rw_1_id, rw_2_id, rw_3_id];
            position_array  = c_array;
            promt           = 'C -';
        }
        else if (5 === i)
        {
            current_1       = rw_1_id;
            other_3         = [ld_1_id, ld_2_id, ld_3_id, rd_1_id, rd_2_id, rd_3_id, lw_1_id, lw_2_id, lw_3_id, c_1_id, c_2_id, c_3_id, rw_2_id, rw_3_id];
            current_2       = rw_2_id;
            other_3         = [ld_1_id, ld_2_id, ld_3_id, rd_1_id, rd_2_id, rd_3_id, lw_1_id, lw_2_id, lw_3_id, c_1_id, c_2_id, c_3_id, rw_1_id, rw_3_id];
            current_3       = rw_3_id;
            other_3         = [ld_1_id, ld_2_id, ld_3_id, rd_1_id, rd_2_id, rd_3_id, lw_1_id, lw_2_id, lw_3_id, c_1_id, c_2_id, c_3_id, rw_1_id, rw_2_id];
            position_array  = rw_array;
            promt           = 'RW -';
        }

        var select_html_1 = '<option value="0">' + promt + '</option>';
        var select_html_2 = '<option value="0">' + promt + '</option>';
        var select_html_3 = '<option value="0">' + promt + '</option>';

        for (var j=0; j<position_array.length; j++)
        {
            if (position_array[j][0] === current_1)
            {
                select_html_1 = select_html_1 + '<option value="' + position_array[j][0] + '" selected>' + position_array[j][1] + '</option>';
            }
            else if (-1 === $.inArray(position_array[j][0], other_1))
            {
                select_html_1 = select_html_1 + '<option value="' + position_array[j][0] + '">' + position_array[j][1] + '</option>';
            }

            if (position_array[j][0] === current_2)
            {
                select_html_2 = select_html_2 + '<option value="' + position_array[j][0] + '" selected>' + position_array[j][1] + '</option>';
            }
            else if (-1 === $.inArray(position_array[j][0], other_2))
            {
                select_html_2 = select_html_2 + '<option value="' + position_array[j][0] + '">' + position_array[j][1] + '</option>';
            }

            if (position_array[j][0] === current_3)
            {
                select_html_3 = select_html_3 + '<option value="' + position_array[j][0] + '" selected>' + position_array[j][1] + '</option>';
            }
            else if (-1 === $.inArray(position_array[j][0], other_3))
            {
                select_html_3 = select_html_3 + '<option value="' + position_array[j][0] + '">' + position_array[j][1] + '</option>';
            }
        }

        $('#line-1-' + i).html(select_html_1);
        $('#line-2-' + i).html(select_html_2);
        $('#line-3-' + i).html(select_html_3);
    }

    player_change();

    $('.lineup-change').on('change', function() {
        var position    = parseInt($(this).data('position'));
        var line        = parseInt($(this).data('line'));
        var player_id   = parseInt($(this).val());

        var player_id_array =
        [
            parseInt($('#line-1-1').val()),
            parseInt($('#line-2-1').val()),
            parseInt($('#line-3-1').val()),
            parseInt($('#line-1-2').val()),
            parseInt($('#line-2-2').val()),
            parseInt($('#line-3-2').val()),
            parseInt($('#line-1-3').val()),
            parseInt($('#line-2-3').val()),
            parseInt($('#line-3-3').val()),
            parseInt($('#line-1-4').val()),
            parseInt($('#line-2-4').val()),
            parseInt($('#line-3-4').val()),
            parseInt($('#line-1-5').val()),
            parseInt($('#line-2-5').val()),
            parseInt($('#line-3-5').val())
        ];

        if      (1 === position) { position_array = ld_array; }
        else if (2 === position) { position_array = rd_array; }
        else if (3 === position) { position_array = lw_array; }
        else if (4 === position) { position_array =  c_array; }
        else if (5 === position) { position_array = rw_array; }

        for (var i=1; i<=3; i++)
        {
            for (var k=1; k<=5; k++)
            {
                if      (1 === k) { position_array = ld_array; promt = 'LD -'; }
                else if (2 === k) { position_array = rd_array; promt = 'RD -'; }
                else if (3 === k) { position_array = lw_array; promt = 'LW -'; }
                else if (4 === k) { position_array =  c_array; promt = 'C -'; }
                else if (5 === k) { position_array = rw_array; promt = 'RW -'; }

                var line_player = $('#line-' + i + '-' + k);

                var line_player_id = parseInt(line_player.val());

                var select_html = '<option value="0">' + promt + '</option>';

                for (var j=0; j<position_array.length; j++)
                {
                    if (position_array[j][0] === player_id)
                    {
                        if (i === line && k === position)
                        {
                            select_html = select_html + '<option selected value="' + position_array[j][0] + '">' + position_array[j][1] + '</option>';
                        }
                        else
                        {
                            if (-1 === $.inArray(position_array[j][0], player_id_array))
                            {
                                select_html = select_html + '<option value="' + position_array[j][0] + '">' + position_array[j][1] + '</option>';
                            }
                        }
                    }
                    else
                    {
                        if (position_array[j][0] === line_player_id)
                        {
                            select_html = select_html + '<option selected value="' + position_array[j][0] + '">' + position_array[j][1] + '</option>';
                        }
                        else
                        {
                            if (-1 === $.inArray(position_array[j][0], player_id_array))
                            {
                                select_html = select_html + '<option value="' + position_array[j][0] + '">' + position_array[j][1] + '</option>';
                            }
                        }
                    }
                }

                line_player.html(select_html);
            }
        }
    });

    $('.player-change').on('change', function() {
        player_change();
    });
});

function player_change()
{
    $('.tr-player').removeClass('info');

    var player_change = $('.player-change');

    for (var i=0; i<player_change.length; i++)
    {
        $('#tr-' + $(player_change[i]).val()).addClass('info');
    }
}function sort_grid(grid, type, colNum)
{
    var position = ['GK', 'LD', 'RD', 'LW', 'C', 'RW'];
    var phisical = [11, 10, 12, 9, 13, 8, 14, 7, 15, 6, 16, 5, 17, 4, 18, 3, 19, 2, 20, 1];

    var tbody = grid.find('tbody');
    tbody = tbody[0];
    var rowsArray = [].slice.call(tbody.rows);

    var compare;
    if ('number' === type) {
        compare = function(rowA, rowB) {
            var a = parseInt(rowA.cells[colNum].innerHTML);
            var b = parseInt(rowB.cells[colNum].innerHTML);
            var order = a - b;
            if (0 !== order)
            {
                return order;
            }
            else
            {
                return $(rowA).data('order') - $(rowB).data('order');
            }
        };
    } else if ('price' === type) {
        compare = function(rowA, rowB) {
            var a = parseInt(rowA.cells[colNum].innerHTML.replace(/\s/g, ''));
            var b = parseInt(rowB.cells[colNum].innerHTML.replace(/\s/g, ''));
            var order = a - b;
            if (0 !== order)
            {
                return order;
            }
            else
            {
                return $(rowA).data('order') - $(rowB).data('order');
            }
        };
    } else if ('position' === type) {
        compare = function(rowA, rowB) {
            var a = $(rowA.cells[colNum]).find('span').html().split('/');
            a = a[0];
            var b = $(rowB.cells[colNum]).find('span').html().split('/');
            b = b[0];
            if (a !== b)
            {
                return $.inArray(a, position) - $.inArray(b, position);
            }
            else
            {
                return $(rowA).data('order') - $(rowB).data('order');
            }
        };
    } else if ('phisical' === type) {
        compare = function(rowA, rowB) {
            var a = $(rowA.cells[colNum]).find('img').attr('src').split('/');
            a = a[3];
            a = a.split('.');
            a = parseInt(a[0]);
            var b = $(rowB.cells[colNum]).find('img').attr('src').split('/');
            b = b[3];
            b = b.split('.');
            b = parseInt(b[0]);
            if (a !== b)
            {
                return $.inArray(a, phisical) - $.inArray(b, phisical);
            }
            else
            {
                return $(rowA).data('order') - $(rowB).data('order');
            }
        };
    } else if ('country' === type) {
        compare = function(rowA, rowB) {
            var a = $(rowA.cells[colNum]).find('img').attr('src').split('/');
            a = a[4];
            a = a.split('.');
            a = parseInt(a[0]);
            var b = $(rowB.cells[colNum]).find('img').attr('src').split('/');
            b = b[4];
            b = b.split('.');
            b = parseInt(b[0]);
            var order = a - b;
            if (0 !== order)
            {
                return order;
            }
            else
            {
                return $(rowA).data('order') - $(rowB).data('order');
            }
        };
    } else if ('player' === type) {
        compare = function(rowA, rowB) {
            var a = $.trim($(rowA.cells[colNum]).find('a').html().replace(/\s/g, ''));
            var b = $.trim($(rowB.cells[colNum]).find('a').html().replace(/\s/g, ''));
            if (a !== b)
            {
                var sort_array = [a, b];
                sort_array.sort();
                return $.inArray(a, sort_array) - $.inArray(b, sort_array);
            }
            else
            {
                return $(rowA).data('order') - $(rowB).data('order');
            }
        };
    } else if ('string' === type) {
        compare = function(rowA, rowB) {
            var a = rowA.cells[colNum].innerHTML;
            var b = rowB.cells[colNum].innerHTML;
            if (a !== b)
            {
                var sort_array = [a, b];
                sort_array.sort();
                return $.inArray(a, sort_array) - $.inArray(b, sort_array);
            }
            else
            {
                return $(rowA).data('order') - $(rowB).data('order');
            }
        };
    }

    rowsArray.sort(compare);

    grid.find('tbody').remove();
    for (var i = 0; i < rowsArray.length; i++) {
        tbody.appendChild(rowsArray[i]);
    }
    grid.append(tbody);
}