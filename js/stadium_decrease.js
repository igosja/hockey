jQuery(document).ready(function () {
    var capacity_input      = $('#capacity');
    var capacity_current    = capacity_input.data('current');
    var one_sit_price       = capacity_input.data('sit_price');

    capacity_input.on('change', function() {
        var capacity_new = parseInt($(this).val());

        if (isNaN(capacity_new))
        {
            capacity_new = 0;
        }

        if (capacity_new > capacity_current)
        {
            capacity_new = capacity_current;
        }
        else if (0 > capacity_new)
        {
            capacity_new = 0;
        }

        var price = get_price(capacity_new, capacity_current, one_sit_price);

        $(this).val(capacity_new);
        $('#stadium-price').html(price.toLocaleString('ru-RU'));

        check_capacity($(this).val());
    });

    $('#capacity-form').on('submit', function () {
        check_capacity(capacity_input.val());

        if ($('input.has-error').length)
        {
            return false;
        }
    });
});

function check_capacity(capacity)
{
    var capacity_input = $('#capacity');
    var capacity_error = $('.capacity-error');

    if ('' !== capacity)
    {
        capacity_error.html('');

        if (capacity_input.hasClass('has-error'))
        {
            capacity_input.removeClass('has-error');
        }
    }
    else
    {
        capacity_input.addClass('has-error');
        capacity_error.html('Введите вместимость.');
    }
}

function get_price(capacity_new, capacity_current, one_sit_price)
{
    return parseInt((Math.pow(capacity_current, 1.1) - Math.pow(capacity_new, 1.1)) * one_sit_price);
}