jQuery(document).ready(function () {
    $('#transfercomment').on('blur', function () {
        check_transfercomment($(this).val());
    });

    $('#transfercomment-form').on('submit', function () {
        var transfercomment_input = $('#transfercomment');

        if (transfercomment_input.length) {
            check_rentcomment(transfercomment_input.val());
        }

        check_transferrating();

        if ($('textarea.has-error').length)
        {
            return false;
        }
    });
});

function check_transfercomment(transfercomment)
{
    var transfercomment_input   = $('#transfercomment');
    var transferrating_plus     = $('#transferrating-plus');
    var transfercomment_error   = $('.transfercomment-error');

    if ('' !== transfercomment || transferrating_plus.is(':checked'))
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

function check_transferrating()
{
    var transferrating_input_1 = $('#transferrating-plus');
    var transferrating_input_2 = $('#transferrating-minus');
    var transferrating_error = $('.transferrating-error');

    if (transferrating_input_1.is(':checked') || transferrating_input_2.is(':checked'))
    {
        transferrating_error.html('');

        if (transferrating_error.hasClass('has-error'))
        {
            transferrating_error.removeClass('has-error');
        }
    }
    else
    {
        transferrating_error.html('Укажите свою оценку сделки.');
    }
}