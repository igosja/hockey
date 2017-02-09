jQuery(document).ready(function () {
    var element_id_filter = $('#filters');
    element_id_filter.find('input').on('change', function() {
        $(this).parents('form').submit();
    });
    element_id_filter.find('select').on('change', function() {
        $(this).parents('form').submit();
    });
});