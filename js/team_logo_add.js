jQuery(document).ready(function () {
    $('#logo').on('change', function () {
        check_logo($(this).val());
    });

    $('#text').on('blur', function () {
        check_text($(this).val());
    });

    $('#team-logo-form').on('submit', function () {
        check_logo($('#logo').val());
        check_text($('#text').val());

        if ($('textarea.has-error').length || $('input.has-error').length)
        {
            return false;
        }
    });
});

function check_logo(logo)
{
    var logo_input = $('#logo');
    var logo_error = $('.logo-error');

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
        text_error.html('Введите комментарий.');
    }
}