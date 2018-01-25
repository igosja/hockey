jQuery(document).ready(function () {
    toggle_special_select();

    $('#position').on('change', function () {
        toggle_special_select();
    });
});

function toggle_special_select()
{
    if (1 === parseInt($('#position').val()))
    {
        $('#special-field').hide();
        $('#special-gk').show();
    }
    else
    {
        $('#special-field').show();
        $('#special-gk').hide();
    }
}