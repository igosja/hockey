jQuery(document).ready(function () {
    toggle_name();

    $('#theme').on('change', function() {
        toggle_name();
    });

    $('#name').on('blur', function () {
        check_name($(this).val());
    });

    $('#moove-form').on('submit', function () {
        check_name($('#name').val());

        if ($('input.has-error').length)
        {
            return false;
        }
    });
});

function toggle_name() {
    if (0 == $('#theme').val()) {
        $('.div-name').show();
    } else {
        $('.div-name').hide();
    }
}

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
        if (0 == $('#theme').val())
        {
            name_input.addClass('has-error');
            name_error.html('Введите заголовок.');
        }
        else
        {
            if (name_input.hasClass('has-error'))
            {
                name_input.removeClass('has-error');
            }
        }
    }
}