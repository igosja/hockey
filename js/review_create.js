jQuery(document).ready(function () {
    $('#title').on('blur', function () {
        check_title($(this).val());
    });

    $('#text').on('blur', function () {
        check_text($(this).val());
    });

    $('#forumtheme-form').on('submit', function () {
        check_title($('#title').val());
        check_text($('#text').val());

        if ($('textarea.has-error').length || $('input.has-error').length)
        {
            return false;
        }
    });
});

function check_title(title)
{
    var title_input = $('#title');
    var title_error = $('.title-error');

    if ('' !== title)
    {
        title_error.html('');

        if (title_input.hasClass('has-error'))
        {
            title_input.removeClass('has-error');
        }
    }
    else
    {
        title_input.addClass('has-error');
        title_error.html('Введите заголовок.');
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