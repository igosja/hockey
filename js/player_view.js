jQuery(document).ready(function () {
    $('#select-line').on('change', function () {
        var line_id     = $(this).val();
        var player_id   = $(this).data('player');

        $.ajax({
            url: '/json/player_view.php?line_id=' + line_id + '&player_id=' + player_id
        });
    });
    $('#select-national-line').on('change', function () {
        var line_id     = $(this).val();
        var player_id   = $(this).data('player');

        $.ajax({
            url: '/json/player_view.php?national_line_id=' + line_id + '&player_id=' + player_id
        });
    });
});