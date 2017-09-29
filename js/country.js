jQuery(document).ready(function () {
    var relation_body = $('.relation-body');
    $('#relation-link').on('click', function () {
        if (relation_body.hasClass('hidden')) {
            relation_body.removeClass('hidden');
        } else {
            relation_body.addClass('hidden');
        }
    });
});