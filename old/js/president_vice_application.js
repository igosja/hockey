jQuery(document).ready(function () {
    $('#message').on('blur', function () {
        check_message($(this).val());
    });

    $('#message-form').on('submit', function () {
        check_message($('#message').val());

        if ($('textarea.has-error').length)
        {
            return false;
        }
    });
});

function check_message(message)
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
        message_error.html('Введите программу.');
    }
}