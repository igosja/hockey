jQuery(document).ready(function () {
    $('#page').on('change', function () {
        $(this).closest('form').submit();
    });
});