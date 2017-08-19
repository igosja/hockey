jQuery(document).ready(function () {
    $('#page').on('change', function () {
        $(this).closest('form').submit();
    });

    $('#newscomment').on('blur', function () {
        check_newscomment($(this).val());
    });

    $('#newscomment-form').on('submit', function () {
        check_newscomment($('#newscomment').val());

        if ($('textarea.has-error').length)
        {
            return false;
        }
    })
});

function check_newscomment(newscomment)
{
    var newscomment_input = $('#newscomment');
    var newscomment_error = $('.newscomment-error');

    if ('' !== newscomment)
    {
        newscomment_error.html('');

        if (newscomment_input.hasClass('has-error'))
        {
            newscomment_input.removeClass('has-error');
        }
    }
    else
    {
        newscomment_input.addClass('has-error');
        newscomment_error.html('Введите комментарий.');
    }
}