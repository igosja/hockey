jQuery(document).ready(function () {
    $('#page').on('change', function () {
        $(this).closest('form').submit();
    });

    $('#text').on('blur', function () {
        check_text($(this).val());
    });

    $('#forumtheme-form').on('submit', function () {
        check_text($('#text').val());

        if ($('textarea.has-error').length)
        {
            return false;
        }
    });
});

function check_text(text)
{
    var text_input = $('#text');
    var text_error = $('.text-error');

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
        text_error.html('Введите сообщение.');
    }
}