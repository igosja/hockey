var email_patter = /^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/;

jQuery(document).ready(function () {
    $('#season_id').on('change', function () {
        $(this).closest('form').submit();
    });

    $('#stage_id').on('change', function () {
        $(this).closest('form').submit();
    });

    $('#statistictype').on('change', function () {
        $(this).closest('form').submit();
    });

    $('#country_id').on('change', function () {
        $(this).closest('form').submit();
    });

    $('#page').on('change', function () {
        $(this).closest('form').submit();
    });

    $('#ratingtype').on('change', function () {
        $(this).closest('form').submit();
    });
});