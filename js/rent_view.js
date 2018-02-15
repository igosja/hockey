jQuery(document).ready(function () {
    $('.reject').on('click', function() {
        var deal_comment_block = $('.deal-comment-block');
        deal_comment_block.show();
        $('body, html').animate({ scrollTop: deal_comment_block.offset().top }, 1000); //1100 - скорость
    });

    $('#transfercomment').on('blur', function () {
        check_transfercomment($(this).val());
    });

    $('#transfercomment-form').on('submit', function () {
        check_transfercomment($('#transfercomment').val());

        if ($('textarea.has-error').length)
        {
            return false;
        }
    });
});

function check_transfercomment(transfercomment)
{
    var transfercomment_input = $('#transfercomment');
    var transfercomment_error = $('.transfercomment-error');

    if ('' !== transfercomment)
    {
        transfercomment_error.html('');

        if (transfercomment_input.hasClass('has-error'))
        {
            transfercomment_input.removeClass('has-error');
        }
    }
    else
    {
        transfercomment_input.addClass('has-error');
        transfercomment_error.html('Введите комментарий.');
    }
}