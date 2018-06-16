jQuery(document).ready(function () {
    $('#transfermoney-team, #transfermoney-country').on('blur', function () {
        check_team_country();
    });

    $('#transfermoney-sum').on('blur', function () {
        check_sum($(this).val());
    });

    $('#transfermoney-comment').on('blur', function () {
        check_comment($(this).val());
    });

    $('#transfermoney-form').on('submit', function () {
        check_team_country();
        check_sum($('#transfermoney-sum').val());
        check_comment($('#transfermoney-comment').val());

        if ($('input.has-error').length || $('select.has-error').length)
        {
            return false;
        }
    });
});

function check_team_country()
{
    var team_input = $('#transfermoney-team');
    var country_input = $('#transfermoney-country');
    var div_error = $('.transfermoney-country-error');
    var team_id = parseInt(team_input.val());
    var country_id = parseInt(country_input.val());

    if (team_id || country_id)
    {
        div_error.html('');

        if (team_input.hasClass('has-error'))
        {
            team_input.removeClass('has-error');
        }

        if (country_input.hasClass('has-error'))
        {
            country_input.removeClass('has-error');
        }
    }
    else
    {
        team_input.addClass('has-error');
        country_input.addClass('has-error');
        div_error.html('Выберите команду или федерацию.');
    }
}

function check_sum(sum)
{
    var sum_input = $('#transfermoney-sum');
    var sum_error = $('.transfermoney-sum-error');

    sum = parseInt(sum);

    if (0 < sum)
    {
        if (parseInt(sum) <= parseInt(sum_input.data('available')))
        {
            sum_error.html('');

            if (sum_input.hasClass('has-error'))
            {
                sum_input.removeClass('has-error');
            }
        }
        else
        {
            sum_input.addClass('has-error');
            sum_error.html('Недостаточно денег на счету.');
        }
    }
    else
    {
        sum_input.addClass('has-error');
        sum_error.html('Введите сумму.');
    }
}

function check_comment(sum)
{
    var comment_input = $('#transfermoney-comment');
    var comment_error = $('.transfermoney-comment-error');

    if ('' !== sum)
    {
        comment_error.html('');

        if (comment_input.hasClass('has-error'))
        {
            comment_input.removeClass('has-error');
        }
    }
    else
    {
        comment_input.addClass('has-error');
        comment_error.html('Введите комментарий.');
    }
}