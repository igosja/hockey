jQuery(document).ready(function () {
    $('#stadium-capacity').on('change', function() {
        var capacity_new    = parseInt($(this).val());
        var one_sit_price   = 150;

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

        var price = parseInt((Math.pow(capacity_current, 1.1) - Math.pow(capacity_new, 1.1)) * one_sit_price);

        $(this).val(capacity_new);
        $('#stadium-price').html(price);
    });
});