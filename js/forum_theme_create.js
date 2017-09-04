jQuery(document).ready(function () {
    $('#name').on('blur', function () {
        check_name($(this).val());
    });

    $('#text').on('blur', function () {
        check_text($(this).val());
    });

    $('#forumtheme-form').on('submit', function () {
        check_name($('#name').val());
        check_text($('#text').val());

        if ($('textarea.has-error').length || $('input.has-error').length)
        {
            return false;
        }
    });
});

function check_name(name)
{
    var name_input = $('#name');
    var name_error = $('.name-error');

    if ('' !== name)
    {
        name_error.html('');

        if (name_input.hasClass('has-error'))
        {
            name_input.removeClass('has-error');
        }
    }
    else
    {
        name_input.addClass('has-error');
        name_error.html('Введите заголовок.');
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
        text_error.html('Введите сообщение.');
    }
}