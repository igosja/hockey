jQuery(document).ready(function () {
    $('#page').on('change', function () {
        $(this).closest('form').submit();
    });

    $('#message').on('blur', function () {
        check_text($(this).val());
    });

    $('#message-form').on('submit', function () {
        check_text($('#message').val());

        if ($('textarea.has-error').length)
        {
            return false;
        }
    });
});

function check_text(message)
{
    var message_input = $('#message');
    var message_error = $('.message-error');

    if ('' !== message)
    {
        message_error.html('');

        if (message_input.hasClass('has-error'))
        {
            message_input.removeClass('has-error');
        }
    }
    else
    {
        message_input.addClass('has-error');
        message_error.html('Введите сообщение.');
    }
}