jQuery(document).ready(function () {
    $('#questionnaire-email').on('blur', function () {
        check_email($(this).val());
    });

    $('#questionnaire-form').on('submit', function () {
        check_email($('#questionnaire-email').val());

        if ($('input.has-error').length)
        {
            return false;
        }
    });
});

function check_email(email)
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