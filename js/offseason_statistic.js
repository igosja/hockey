jQuery(document).ready(function () {
    $('#statistictype').on('change', function () {
        $(this).closest('form').submit();
    });
});