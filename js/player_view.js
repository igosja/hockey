jQuery(document).ready(function () {
    $('#select-line').on('change', function () {
        var line_id     = $(this).val();
        var player_id   = $(this).data('player');

        $.ajax({
            url: '/json.php?line_id=' + line_id + '&player_id=' + player_id
        });
    });
});