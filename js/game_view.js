jQuery(document).ready(function () {
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