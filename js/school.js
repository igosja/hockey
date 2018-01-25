jQuery(document).ready(function () {
    toggle_special_select();

    $('#position').on('change', function () {
        toggle_special_select();
    });
});

function toggle_special_select()
{
    if (1 === parseInt($('#position').val))
    {
        $('#special-field').hide();
        $('label[for=special-field]').hide();
        $('#special-gk').show();
        $('label[for=special-gk]').show();
    }
    else
    {
        $('#special-field').show();
        $('label[for=special-field]').show();
        $('#special-gk').hide();
        $('label[for=special-gk]').hide();
    }
}