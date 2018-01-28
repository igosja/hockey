jQuery(document).ready(function () {
    var grid = $('#grid');
    var grid_th = grid.find('thead').find('th');
    grid_th.on('click', function() {
        sort_grid(grid, $(this).data('type'), $.inArray(this, grid_th));
    });
});

function sort_grid(grid, type, colNum)
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