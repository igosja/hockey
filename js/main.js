var email_pattern = /^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/;
var wysibbSettings = {
    buttons: "bold,italic,underline,strike,|,img,link,|,bullist,numlist,|,quote,table,smilebox",
    lang: "ru",
    smileList: [
        {img: '<img src="/js/wysibb/theme/default/img/smiles/sm01.png" class="sm">', bbcode:":)"},
        {img: '<img src="/js/wysibb/theme/default/img/smiles/sm02.png" class="sm">', bbcode:":("},
        {img: '<img src="/js/wysibb/theme/default/img/smiles/sm03.png" class="sm">', bbcode:":D"},
        {img: '<img src="/js/wysibb/theme/default/img/smiles/sm04.png" class="sm">', bbcode:";)"},
        {img: '<img src="/js/wysibb/theme/default/img/smiles/sm05.png" class="sm">', bbcode:":boss:"},
        {img: '<img src="/js/wysibb/theme/default/img/smiles/sm06.png" class="sm">', bbcode:":applause:"},
        {img: '<img src="/js/wysibb/theme/default/img/smiles/sm07.png" class="sm">', bbcode:":surprise:"},
        {img: '<img src="/js/wysibb/theme/default/img/smiles/sm08.png" class="sm">', bbcode:":sick:"},
        {img: '<img src="/js/wysibb/theme/default/img/smiles/sm09.png" class="sm">', bbcode:":angry:"}
    ]
};

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
        var sortOrder = $(this).data('order');
        sort_grid(grid, $(this).data('type'), $.inArray(this, grid_th), sortOrder);
        if ('desc' === sortOrder) {
            $(this).data('order', 'asc');
        } else {
            $(this).data('order', 'desc');
        }
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

    var stadium_decrease_input      = $('#stadium-decrease-input');
    var stadium_decrease_current    = stadium_decrease_input.data('current');
    var stadium_decrease_sit_price  = stadium_decrease_input.data('sit_price');

    stadium_decrease_input.on('change', function() {
        var capacity_new = parseInt($(this).val());

        if (isNaN(capacity_new))
        {
            capacity_new = 0;
        }

        if (capacity_new > stadium_decrease_current)
        {
            capacity_new = stadium_decrease_current;
        }
        else if (0 > capacity_new)
        {
            capacity_new = 0;
        }

        var price = get_decrease_price(capacity_new, stadium_decrease_current, stadium_decrease_sit_price);

        $(this).val(capacity_new);
        $('#stadium-decrease-price').html(price.toLocaleString('ru-RU'));

        check_decrease_capacity($(this).val());
    });

    $('#stadium-decrease-form').on('submit', function () {
        check_decrease_capacity(stadium_decrease_input.val());

        if ($('input.has-error').length)
        {
            return false;
        }
    });

    var stadium_increase_input      = $('#stadium-increase-input');
    var stadium_increase_current    = stadium_increase_input.data('current');
    var stadium_increase_sit_price  = stadium_increase_input.data('sit_price');

    stadium_increase_input.on('change', function() {
        var capacity_new = parseInt($(this).val());

        if (isNaN(capacity_new))
        {
            capacity_new = 0;
        }

        if (capacity_new < stadium_increase_current)
        {
            capacity_new = stadium_increase_current;
        }
        else if (25000 < capacity_new)
        {
            capacity_new = 25000;
        }

        var price = get_increase_price(capacity_new, stadium_increase_current, stadium_increase_sit_price);

        $(this).val(capacity_new);
        $('#stadium-increase-price').html(price.toLocaleString('ru-RU'));

        check_increase_capacity($(this).val(), stadium_increase_current, stadium_increase_sit_price);
    });

    $('#capacity-form').on('submit', function () {
        check_increase_capacity(stadium_increase_input.val(), stadium_increase_current, stadium_increase_sit_price);

        if ($('input.has-error').length)
        {
            return false;
        }
    });
    var countryUpdateNewsTextArea = $('#country-news-update-text');

    $('#country-news-update-title').on('blur', function () {
        check_country_news_update_title($(this).val());
    });

    countryUpdateNewsTextArea.on('blur', function () {
        if (1 === countryUpdateNewsTextArea.data('bb'))
        {
            countryUpdateNewsTextArea.sync();
        }
        check_country_news_update_text($(this).val());
    });

    $('#country-news-update-form').on('submit', function () {
        if (1 === countryUpdateNewsTextArea.data('bb'))
        {
            countryUpdateNewsTextArea.sync();
        }

        check_country_news_update_title($('#country-news-update-title').val());
        check_country_news_update_text(countryUpdateNewsTextArea.val());

        if ($('textarea.has-error').length || $('input.has-error').length)
        {
            return false;
        }
    });

    if (1 === countryUpdateNewsTextArea.data('bb'))
    {
        countryUpdateNewsTextArea.wysibb(wysibbSettings);
    }
    var countryNewsCreateTextArea = $('#country-news-create-text');

    $('#country-news-create-title').on('blur', function () {
        check_country_news_create_title($(this).val());
    });

    countryNewsCreateTextArea.on('blur', function () {
        if (1 === countryNewsCreateTextArea.data('bb'))
        {
            countryNewsCreateTextArea.sync();
        }
        check_country_news_create_text($(this).val());
    });

    $('#country-news-create-form').on('submit', function () {
        if (1 === countryNewsCreateTextArea.data('bb'))
        {
            countryNewsCreateTextArea.sync();
        }
        check_country_news_create_title($('#country-news-create-title').val());
        check_country_news_create_text(countryNewsCreateTextArea.val());

        if ($('textarea.has-error').length || $('input.has-error').length)
        {
            return false;
        }
    });

    if (1 === countryNewsCreateTextArea.data('bb'))
    {
        countryNewsCreateTextArea.wysibb(wysibbSettings);
    }

    $('#team-logo-file').on('change', function () {
        check_logo($(this).val());
    });

    $('#team-logo-text').on('blur', function () {
        check_logo_text($(this).val());
    });

    $('#team-logo-form').on('submit', function () {
        check_logo($('#team-logo-file').val());
        check_logo_text($('#team-logo-text').val());

        if ($('textarea.has-error').length || $('input.has-error').length)
        {
            return false;
        }
    });

    $('#password-restore').on('blur', function () {
        check_password_restore($(this).val());
    });

    $('#password-restore-form').on('submit', function () {
        check_password_restore($('#password-restore').val());

        if ($('input.has-error').length)
        {
            return false;
        }
    });

    $('#password-login').on('blur', function () {
        check_password_login_email();
    });

    $('#password-email').on('blur', function () {
        check_password_login_email();
    });

    $('#password-form').on('submit', function () {
        check_password_login_email();

        if ($('input.has-error').length)
        {
            return false;
        }
    });

    $('.show-full-table').on('click', function() {
        $('.show-full-table').hide();
        var table_list = $('table');
        table_list.find('th').removeClass('hidden-xs');
        table_list.find('td').removeClass('hidden-xs');
    });

    $(document).on('click', '.up', function () {
        var currentOrder = $(this).parents('tr').attr('data-order');
        currentOrder = parseInt(currentOrder);

        if (currentOrder > 0) {
            $('tr[data-order=' + (currentOrder - 1) + ']').attr('data-order', currentOrder);
            $(this).parents('tr').attr('data-order', currentOrder - 1);

            coach_sort_table($('#grid'));
        }
    });

    $(document).on('click', '.down', function () {
        var currentOrder = $(this).parents('tr').attr('data-order');
        currentOrder = parseInt(currentOrder);
        var lastOrder = $(this).parents('tbody').find('tr');
        lastOrder = lastOrder[lastOrder.length-1];
        lastOrder = $(lastOrder).attr('data-order');
        lastOrder = parseInt(lastOrder);

        if (currentOrder < lastOrder) {
            $('tr[data-order=' + (currentOrder + 1) + ']').attr('data-order', currentOrder);
            $(this).parents('tr').attr('data-order', currentOrder + 1);

            coach_sort_table($('#grid'));
        }
    });

    $('.coach-sort').on('click', function() {
        $('.up, .down').toggle();
    });
});

function coach_sort_table(table)
{
    var tbody = table.find('tbody');
    tbody = tbody[0];
    var rowsArray = [].slice.call(tbody.rows);

    var compare = function (rowA, rowB) {
        return $(rowA).data('order') - $(rowB).data('order');
    };

    rowsArray.sort(compare);

    table.find('tbody').remove();
    var data = [];
    for (var i = 0; i < rowsArray.length; i++) {
        tbody.appendChild(rowsArray[i]);
        data.push($(rowsArray[i]).data('player') + ':' + $(rowsArray[i]).data('order'));
    }

    $.ajax({
        data: 'player_array=' + data,
        method: 'post',
        url: '/json/coach_sort.php'
    });

    table.append(tbody);
}

function check_password_login_email()
{
    var login_input = $('#password-login');
    var email_input = $('#password-email');
    var password_error = $('.password-error');
    var email_error = $('.password-email-error');

    if ('' !== login_input.val() || '' !== email_input.val())
    {
        if ('' === email_input.val() || ('' !== email_input.val() && email_pattern.test(email_input.val())))
        {
            password_error.html('');
            email_error.html('');

            if (login_input.hasClass('has-error'))
            {
                login_input.removeClass('has-error');
            }

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
        login_input.addClass('has-error');
        password_error.html('Введите логин/email.');
    }
}

function check_password_restore(password)
{
    var password_input = $('#password-restore');
    var password_error = $('.password-restore-error');

    if ('' !== password)
    {
        password_error.html('');
        password_input.html('');

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

function check_logo(logo)
{
    var logo_input = $('#team-logo-file');
    var logo_error = $('.team-logo-file-error');

    if ('' !== logo)
    {
        if (logo_input[0].files[0])
        {
            if ('image/png' !== logo_input[0].files[0].type)
            {
                logo_input.addClass('has-error');
                logo_error.html('Картинка должна быть в png-формате.');
            }
            else if (logo_input[0].files[0].size > 51200)
            {
                logo_input.addClass('has-error');
                logo_error.html('Объем файла должен быть не более 50 килобайт.');
            }
            else
            {
                logo_error.html('');

                if (logo_input.hasClass('has-error'))
                {
                    logo_input.removeClass('has-error');
                }
            }
        }
        else
        {
            logo_input.addClass('has-error');
            logo_error.html('Выберите файл.');
        }
    }
    else
    {
        logo_input.addClass('has-error');
        logo_error.html('Выберите файл.');
    }
}

function check_logo_text(text)
{
    var text_input = $('#team-logo-text');
    var text_error = $('.team-logo-text-error');

    if ('' !== text)
    {
        text_error.html('');

        if (text_input.hasClass('has-error'))
        {
            text_input.removeClass('has-error');
        }
    }
    else
    {
        text_input.addClass('has-error');
        text_error.html('Введите комментарий.');
    }
}

function check_country_news_create_title(newstitle)
{
    var newstitle_input = $('#country-news-create-title');
    var newstitle_error = $('.country-news-create-title-error');

    if ('' !== newstitle)
    {
        newstitle_error.html('');

        if (newstitle_input.hasClass('has-error'))
        {
            newstitle_input.removeClass('has-error');
        }
    }
    else
    {
        newstitle_input.addClass('has-error');
        newstitle_error.html('Введите заголовок.');
    }
}

function check_country_news_create_text(newstext)
{
    var newstext_input = $('#country-news-create-text');
    var newstext_error = $('.country-news-create-text-error');

    if ('' !== newstext)
    {
        newstext_error.html('');

        if (newstext_input.hasClass('has-error'))
        {
            newstext_input.removeClass('has-error');
        }
    }
    else
    {
        newstext_input.addClass('has-error');
        newstext_error.html('Введите текст.');
    }
}

function check_country_news_update_title(newstitle)
{
    var newstitle_input = $('#country-news-update-title');
    var newstitle_error = $('.country-news-update-title-error');

    if ('' !== newstitle)
    {
        newstitle_error.html('');

        if (newstitle_input.hasClass('has-error'))
        {
            newstitle_input.removeClass('has-error');
        }
    }
    else
    {
        newstitle_input.addClass('has-error');
        newstitle_error.html('Введите заголовок.');
    }
}

function check_country_news_update_text(newstext)
{
    var newstext_input = $('#country-news-update-text');
    var newstext_error = $('.country-news-update-text-error');

    if ('' !== newstext)
    {
        newstext_error.html('');

        if (newstext_input.hasClass('has-error'))
        {
            newstext_input.removeClass('has-error');
        }
    }
    else
    {
        newstext_input.addClass('has-error');
        newstext_error.html('Введите текст.');
    }
}

function check_increase_capacity(capacity, capacity_current, one_sit_price)
{
    var capacity_input = $('#stadium-increase-input');
    var capacity_error = $('.stadium-increase-error');
    var price = get_increase_price(capacity, capacity_current, one_sit_price);

    price = parseInt(price);

    if (0 < capacity)
    {
        if (parseInt(price) <= parseInt(capacity_input.data('available')))
        {
            capacity_error.html('');

            if (capacity_input.hasClass('has-error'))
            {
                capacity_input.removeClass('has-error');
            }
        }
        else
        {
            capacity_input.addClass('has-error');
            capacity_error.html('Недостаточно денег на счету.');
        }
    }
    else
    {
        capacity_input.addClass('has-error');
        capacity_error.html('Введите вместимость.');
    }
}

function get_increase_price(capacity_new, capacity_current, one_sit_price)
{
    return parseInt((Math.pow(capacity_new, 1.1) - Math.pow(capacity_current, 1.1)) * one_sit_price);
}

function check_decrease_capacity(capacity)
{
    var capacity_input = $('#stadium-decrease-input');
    var capacity_error = $('.stadium-decrease-error');

    if ('' !== capacity)
    {
        capacity_error.html('');

        if (capacity_input.hasClass('has-error'))
        {
            capacity_input.removeClass('has-error');
        }
    }
    else
    {
        capacity_input.addClass('has-error');
        capacity_error.html('Введите вместимость.');
    }
}

function get_decrease_price(capacity_new, capacity_current, one_sit_price)
{
    return parseInt((Math.pow(capacity_current, 1.1) - Math.pow(capacity_new, 1.1)) * one_sit_price);
}

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
        if (email_pattern.test(email))
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
        if (email_pattern.test(email))
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

function sort_grid(grid, type, colNum, sortOrder)
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
            var order;

            if ('desc' === sortOrder)
            {
                order = b - a;
            }
            else
            {
                order = a - b;
            }

            if (0 !== order)
            {
                return order;
            }
            else
            {
                if ('desc' === sortOrder)
                {
                    return $(rowB).data('order') - $(rowA).data('order');
                }
                else
                {
                    return $(rowA).data('order') - $(rowB).data('order');
                }
            }
        };
    } else if ('price' === type) {
        compare = function(rowA, rowB) {
            var a = parseInt(rowA.cells[colNum].innerHTML.replace(/\s/g, ''));
            var b = parseInt(rowB.cells[colNum].innerHTML.replace(/\s/g, ''));
            var order;

            if ('desc' === sortOrder)
            {
                order = b - a;
            }
            else
            {
                order = a - b;
            }

            if (0 !== order)
            {
                return order;
            }
            else
            {
                if ('desc' === sortOrder)
                {
                    return $(rowB).data('order') - $(rowA).data('order');
                }
                else
                {
                    return $(rowA).data('order') - $(rowB).data('order');
                }
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
                if ('desc' === sortOrder)
                {
                    return $.inArray(b, position) - $.inArray(a, position);
                }
                else
                {
                    return $.inArray(a, position) - $.inArray(b, position);
                }
            }
            else
            {
                if ('desc' === sortOrder)
                {
                    return $(rowB).data('order') - $(rowA).data('order');
                }
                else
                {
                    return $(rowA).data('order') - $(rowB).data('order');
                }
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
                if ('desc' === sortOrder)
                {
                    return $.inArray(b, phisical) - $.inArray(a, phisical);
                }
                else
                {
                    return $.inArray(a, phisical) - $.inArray(b, phisical);
                }
            }
            else
            {
                if ('desc' === sortOrder)
                {
                    return $(rowB).data('order') - $(rowA).data('order');
                }
                else
                {
                    return $(rowA).data('order') - $(rowB).data('order');
                }
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
            var order;

            if ('desc' === sortOrder)
            {
                order = b - a;
            }
            else
            {
                order = a - b;
            }

            if (0 !== order)
            {
                return order;
            }
            else
            {
                if ('desc' === sortOrder)
                {
                    return $(rowB).data('order') - $(rowA).data('order');
                }
                else
                {
                    return $(rowA).data('order') - $(rowB).data('order');
                }
            }
        };
    } else if ('style' === type) {
        compare = function(rowA, rowB) {
            var a = $(rowA.cells[colNum]).find('img');
            if (a.length) {
                a = a.attr('src').split('/');
                a = a[3];
                a = a.split('.');
                a = parseInt(a[0]);
            } else {
                a = 0;
            }
            var b = $(rowB.cells[colNum]).find('img');
            if (b.length) {
                b = b.attr('src').split('/');
                b = b[3];
                b = b.split('.');
                b = parseInt(b[0]);
            } else {
                b = 0;
            }
            var order;

            if ('desc' === sortOrder)
            {
                order = b - a;
            }
            else
            {
                order = a - b;
            }

            if (0 !== order)
            {
                return order;
            }
            else
            {
                if ('desc' === sortOrder)
                {
                    return $(rowB).data('order') - $(rowA).data('order');
                }
                else
                {
                    return $(rowA).data('order') - $(rowB).data('order');
                }
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

                if ('desc' === sortOrder)
                {
                    return $.inArray(b, sort_array) - $.inArray(a, sort_array);
                }
                else
                {
                    return $.inArray(a, sort_array) - $.inArray(b, sort_array);
                }
            }
            else
            {
                if ('desc' === sortOrder)
                {
                    return $(rowB).data('order') - $(rowA).data('order');
                }
                else
                {
                    return $(rowA).data('order') - $(rowB).data('order');
                }
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

                if ('desc' === sortOrder)
                {
                    return $.inArray(b, sort_array) - $.inArray(a, sort_array);
                }
                else
                {
                    return $.inArray(a, sort_array) - $.inArray(b, sort_array);
                }
            }
            else
            {
                if ('desc' === sortOrder)
                {
                    return $(rowB).data('order') - $(rowA).data('order');
                }
                else
                {
                    return $(rowA).data('order') - $(rowB).data('order');
                }
            }
        };
    } else if ('increment' === type) {
        compare = function(rowA, rowB) {
            if ('desc' === sortOrder)
            {
                return $(rowB).data('order') - $(rowA).data('order');
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

    $('.up, .down, .coach-sort').remove();
}