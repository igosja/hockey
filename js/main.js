var email_patter = /^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/;

jQuery(document).ready(function () {
    $('.submit-on-change').on('change', function () {
        $(this).closest('form').submit();
    });

    $('#questionnaire-email').on('blur', function () {
        check_questionnaire_email($(this).val());
    });

    $('#questionnaire-form').on('submit', function () {
        check_questionnaire_email($('#questionnaire-email').val());

        if ($('input.has-error').length)
        {
            return false;
        }
    });

    $('#transfercomment-form').on('submit', function () {
        check_transferrating();

        if ($('textarea.has-error').length)
        {
            return false;
        }
    });

    $('#rentcomment-form').on('submit', function () {
        check_rentrating();

        if ($('textarea.has-error').length)
        {
            return false;
        }
    });

    $('#select-line').on('change', function () {
        var line_id     = $(this).val();
        var player_id   = $(this).data('player');

        $.ajax({
            url: '/json/player_view.php?line_id=' + line_id + '&player_id=' + player_id
        });
    });

    $('#select-national-line').on('change', function () {
        var line_id     = $(this).val();
        var player_id   = $(this).data('player');

        $.ajax({
            url: '/json/player_view.php?national_line_id=' + line_id + '&player_id=' + player_id
        });
    });

    var relation_body = $('.relation-body');
    $('#relation-link').on('click', function () {
        if (relation_body.hasClass('hidden')) {
            relation_body.removeClass('hidden');
        } else {
            relation_body.addClass('hidden');
        }
    });

    var grid = $('#grid');
    var grid_th = grid.find('thead').find('th');
    grid_th.on('click', function() {
        sort_grid(grid, $(this).data('type'), $.inArray(this, grid_th));
    });

    $('#signup-login').on('blur', function () {
        check_signup_login($(this).val());
    });

    $('#signup-password').on('blur', function () {
        check_signup_password($(this).val());
    });

    $('#signup-email').on('blur', function () {
        check_signup_email($(this).val());
    });

    $('#signup-form').on('submit', function () {
        check_signup_login($('#signup-login').val());
        check_signup_password($('#signup-password').val());
        check_signup_email($('#signup-email').val());

        if ($('input.has-error').length)
        {
            return false;
        }
    });

    toggle_school_special_select();

    $('#school-position').on('change', function () {
        toggle_school_special_select();
    });

    $('#newscomment').on('blur', function () {
        check_newscomment($(this).val());
    });

    $('#newscomment-form').on('submit', function () {
        check_newscomment($('#newscomment').val());

        if ($('textarea.has-error').length)
        {
            return false;
        }
    });

    $('#gamecomment').on('blur', function () {
        check_gamecomment($(this).val());
    });

    $('#gamecomment-form').on('submit', function () {
        check_gamecomment($('#gamecomment').val());

        if ($('textarea.has-error').length)
        {
            return false;
        }
    });

    $(document).on('click', '.phisical-change-cell', function() {
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

function check_gamecomment(gamecomment)
{
    var gamecomment_input = $('#gamecomment');
    var gamecomment_error = $('.gamecomment-error');

    if ('' !== gamecomment)
    {
        gamecomment_error.html('');

        if (gamecomment_input.hasClass('has-error'))
        {
            gamecomment_input.removeClass('has-error');
        }
    }
    else
    {
        gamecomment_input.addClass('has-error');
        gamecomment_error.html('Введите комментарий.');
    }
}

function check_newscomment(newscomment)
{
    var newscomment_input = $('#newscomment');
    var newscomment_error = $('.newscomment-error');

    if ('' !== newscomment)
    {
        newscomment_error.html('');

        if (newscomment_input.hasClass('has-error'))
        {
            newscomment_input.removeClass('has-error');
        }
    }
    else
    {
        newscomment_input.addClass('has-error');
        newscomment_error.html('Введите комментарий.');
    }
}

function toggle_school_special_select()
{
    if (1 === parseInt($('#school-position').val()))
    {
        $('#school-special-field').hide();
        $('#school-special-gk').show();
    }
    else
    {
        $('#school-special-field').show();
        $('#school-special-gk').hide();
    }
}

function check_signup_login(login)
{
    if ('' !== login)
    {
        $.ajax({
            data: {signup_login: login},
            dataType: 'json',
            method: 'POST',
            url: '/json/signup.php',
            success: function (data) {
                var login_input = $('#signup-login');
                var login_error = $('.signup-login-error');

                if (data)
                {
                    login_error.html('');

                    if (login_input.hasClass('has-error'))
                    {
                        login_input.removeClass('has-error');
                    }
                }
                else
                {
                    login_input.addClass('has-error');
                    login_error.html('Такой логин уже занят.');
                }
            }
        });
    }
    else
    {
        $('#signup-login').addClass('has-error');
        $('.signup-login-error').html('Введите логин.');
    }
}

function check_signup_password(password)
{
    var password_input = $('#signup-password');
    var password_error = $('.signup-password-error');

    if ('' !== password)
    {
        password_error.html('');

        if (password_input.hasClass('has-error'))
        {
            password_input.removeClass('has-error');
        }
    }
    else
    {
        password_input.addClass('has-error');
        password_error.html('Введите пароль.');
    }
}

function check_signup_email(email)
{
    if ('' !== email)
    {
        if (email_patter.test(email))
        {
            $.ajax({
                data: {signup_email: email},
                dataType: 'json',
                method: 'POST',
                url: '/json/signup.php',
                success: function (data) {
                    var email_input = $('#signup-email');
                    var email_error = $('.signup-email-error');

                    if (data)
                    {
                        email_error.html('');

                        if (email_input.hasClass('has-error'))
                        {
                            email_input.removeClass('has-error');
                        }
                    }
                    else
                    {
                        email_input.addClass('has-error');
                        email_error.html('Такой email уже занят.');
                    }
                }
            });
        }
        else
        {
            $('#signup-email').addClass('has-error');
            $('.signup-email-error').html('Введите корректный email.');
        }
    }
    else
    {
        $('#signup-email').addClass('has-error');
        $('.signup-email-error').html('Введите email.');
    }
}

function check_rentrating()
{
    var rentrating_input_1 = $('#rentrating-plus');
    var rentrating_input_2 = $('#rentrating-minus');
    var rentrating_error = $('.rentrating-error');

    if (rentrating_input_1.is(':checked') || rentrating_input_2.is(':checked'))
    {
        rentrating_error.html('');

        if (rentrating_error.hasClass('has-error'))
        {
            rentrating_error.removeClass('has-error');
        }
    }
    else
    {
        rentrating_error.html('Укажите свою оценку сделки.');
    }
}

function check_transferrating()
{
    var transferrating_input_1 = $('#transferrating-plus');
    var transferrating_input_2 = $('#transferrating-minus');
    var transferrating_error = $('.transferrating-error');

    if (transferrating_input_1.is(':checked') || transferrating_input_2.is(':checked'))
    {
        transferrating_error.html('');

        if (transferrating_error.hasClass('has-error'))
        {
            transferrating_error.removeClass('has-error');
        }
    }
    else
    {
        transferrating_error.html('Укажите свою оценку сделки.');
    }
}

function check_questionnaire_email(email)
{
    var email_input = $('#questionnaire-email');
    var email_error = $('.questionnaire-email-error');

    if ('' !== email)
    {
        if (email_patter.test(email))
        {
            email_error.html('');

            if (email_input.hasClass('has-error'))
            {
                email_input.removeClass('has-error');
            }
        }
        else
        {
            email_input.addClass('has-error');
            email_error.html('Введите корректный email.');
        }
    }
    else
    {
        email_input.addClass('has-error');
        email_error.html('Введите email.');
    }
}

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
    } else if ('increment' === type) {
        compare = function(rowA, rowB) {
            return $(rowA).data('order') - $(rowB).data('order');
        };
    }

    rowsArray.sort(compare);

    grid.find('tbody').remove();
    for (var i = 0; i < rowsArray.length; i++) {
        tbody.appendChild(rowsArray[i]);
    }
    grid.append(tbody);
}