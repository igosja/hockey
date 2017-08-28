jQuery(document).ready(function () {
    $('#season_id').on('change', function () {
        $(this).closest('form').submit();
    });
});