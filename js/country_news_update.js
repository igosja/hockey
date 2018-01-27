jQuery(document).ready(function () {
    $('#newstitle').on('blur', function () {
        check_newstitle($(this).val());
    });

    $('#newstext').on('blur', function () {
        check_newstext($(this).val());
    });

    $('#news-form').on('submit', function () {
        check_newstitle($('#newstitle').val());
        check_newstext($('#newstext').val());

        if ($('textarea.has-error').length || $('input.has-error').length)
        {
            return false;
        }
    });

    $("#newstext").wysibb({
        buttons: "bold,italic,underline,strike,|,img,link,|,bullist,numlist,|,quote,table",
        lang: "ru",
    });
});

function check_newstitle(newstitle)
{
    var newstitle_input = $('#newstitle');
    var newstitle_error = $('.newstitle-error');

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

function check_newstext(newstext)
{
    var newstext_input = $('#newstext');
    var newstext_error = $('.newstext-error');

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