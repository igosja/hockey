jQuery(document).ready(function () {
    $('#ratingtype').on('change', function () {
        $(this).closest('form').submit();
    });
});