jQuery(document).ready(function () {
    $('#filters').find('input').on('change', function() {
        $(this).parents('form').submit();
    });
    $('#filters').find('select').on('change', function() {
        $(this).parents('form').submit();
    });
});