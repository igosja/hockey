jQuery(document).ready(function () {
    $('#rentcomment').on('blur', function () {
        check_rentcomment($(this).val());
    });

    $('#rentcomment-form').on('submit', function () {
        check_rentcomment($('#rentcomment').val());
        check_rentrating();

        if ($('textarea.has-error').length)
        {
            return false;
        }
    });
});

function check_rentcomment(rentcomment)
{
    var rentcomment_input = $('#rentcomment');
    var rentrating_plus = $('#rentrating-plus');
    var rentcomment_error = $('.rentcomment-error');

    if ('' !== rentcomment || rentrating_plus.is(':checked'))
    {
        rentcomment_error.html('');

        if (rentcomment_input.hasClass('has-error'))
        {
            rentcomment_input.removeClass('has-error');
        }
    }
    else
    {
        rentcomment_input.addClass('has-error');
        rentcomment_error.html('Введите комментарий.');
    }
}

function check_rentrating()
{
    var rentrating_input_1 = $('#rentrating-plus');
    var rentrating_input_2 = $('#rentrating-minus');
    var rentrating_error = $('.rentrating-error');

    if (rentrating_input_1.is(':checked') || rentrating_input_2.is(':checked'))
    {
        rentrating_error.html('');

        if (rentrating_error.hasClass('has-error'))
        {
            rentrating_error.removeClass('has-error');
        }
    }
    else
    {
        rentrating_error.html('Укажите свою оценку сделки.');
    }
}