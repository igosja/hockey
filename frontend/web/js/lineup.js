jQuery(document).ready(function () {
    var position_array = '';
    var current_1;
    var current_2;
    var current_3;
    var current_4;
    var other_1;
    var other_2;
    var other_3;
    var other_4;
    var prompt;
    var i;
    var j;
    var line_player;
    var line_player_id;
    var select_html;
    var captainSelect = $('#captain');

    var current_gk_1 = gk_1_id;
    var other_gk_1 = [gk_2_id];
    var current_gk_2 = gk_2_id;
    var other_gk_2 = [gk_1_id];
    var position_gk_array = gk_array;
    var prompt_gk = 'GK -';

    var select_gk_html_1 = '<option value="0">' + prompt_gk + '</option>';
    var select_gk_html_2 = '<option value="0">' + prompt_gk + '</option>';

    for (j = 0; j < position_gk_array.length; j++) {
        if (position_gk_array[j][0] === current_gk_1) {
            select_gk_html_1 = select_gk_html_1 + '<option value="' + position_gk_array[j][0] + '" style="background-color: ' + position_gk_array[j][2] + '" selected>' + position_gk_array[j][1] + '</option>';
        } else if (-1 === $.inArray(position_gk_array[j][0], other_gk_1)) {
            select_gk_html_1 = select_gk_html_1 + '<option value="' + position_gk_array[j][0] + '" style="background-color: ' + position_gk_array[j][2] + '">' + position_gk_array[j][1] + '</option>';
        }

        if (position_gk_array[j][0] === current_gk_2) {
            select_gk_html_2 = select_gk_html_2 + '<option value="' + position_gk_array[j][0] + '" style="background-color: ' + position_gk_array[j][2] + '" selected>' + position_gk_array[j][1] + '</option>';
        } else if (-1 === $.inArray(position_gk_array[j][0], other_gk_2)) {
            select_gk_html_2 = select_gk_html_2 + '<option value="' + position_gk_array[j][0] + '" style="background-color: ' + position_gk_array[j][2] + '">' + position_gk_array[j][1] + '</option>';
        }
    }

    $('#line-0-0').html(select_gk_html_1);
    $('#line-1-0').html(select_gk_html_2);

    var captain_id = captainSelect.data('id');
    var select_captain_html = '<option value="0"></option>';

    for (i = 1; i <= 5; i++) {
        if (1 === i) {
            current_1 = ld_1_id;
            other_1 = [ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            current_2 = ld_2_id;
            other_2 = [ld_1_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            current_3 = ld_3_id;
            other_3 = [ld_1_id, ld_2_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            current_4 = ld_4_id;
            other_4 = [ld_1_id, ld_2_id, ld_3_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            position_array = ld_array;
            prompt = 'LD -';
        } else if (2 === i) {
            current_1 = rd_1_id;
            other_1 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            current_2 = rd_2_id;
            other_2 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            current_3 = rd_3_id;
            other_3 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            current_4 = rd_4_id;
            other_4 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            position_array = rd_array;
            prompt = 'RD -';
        } else if (3 === i) {
            current_1 = lw_1_id;
            other_3 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            current_2 = lw_2_id;
            other_3 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            current_3 = lw_3_id;
            other_3 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            current_4 = lw_4_id;
            other_4 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, cf_1_id, cf_2_id, cf_3_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            position_array = lw_array;
            prompt = 'LW -';
        } else if (4 === i) {
            current_1 = cf_1_id;
            other_3 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_2_id, cf_3_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            current_2 = cf_2_id;
            other_3 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_3_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            current_3 = cf_3_id;
            other_3 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_4_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            current_4 = cf_4_id;
            other_4 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, rw_1_id, rw_2_id, rw_3_id, rw_4_id];
            position_array = cf_array;
            prompt = 'CF -';
        } else if (5 === i) {
            current_1 = rw_1_id;
            other_3 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, rw_2_id, rw_3_id, rw_4_id];
            current_2 = rw_2_id;
            other_3 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, rw_1_id, rw_3_id, rw_4_id];
            current_3 = rw_3_id;
            other_3 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, rw_1_id, rw_2_id, rw_4_id];
            current_4 = rw_4_id;
            other_4 = [ld_1_id, ld_2_id, ld_3_id, ld_4_id, rd_1_id, rd_2_id, rd_3_id, rd_4_id, lw_1_id, lw_2_id, lw_3_id, lw_4_id, cf_1_id, cf_2_id, cf_3_id, rw_1_id, rw_2_id, rw_4_id];
            position_array = rw_array;
            prompt = 'RW -';
        }

        var select_html_1 = '<option value="0">' + prompt + '</option>';
        var select_html_2 = '<option value="0">' + prompt + '</option>';
        var select_html_3 = '<option value="0">' + prompt + '</option>';
        var select_html_4 = '<option value="0">' + prompt + '</option>';

        for (j = 0; j < position_array.length; j++) {
            if (position_array[j][0] === current_1) {
                select_html_1 = select_html_1 + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '" selected>' + position_array[j][1] + '</option>';
                if (captain_id === current_1) {
                    select_captain_html = select_captain_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '" selected>' + position_array[j][1] + '</option>';
                } else {
                    select_captain_html = select_captain_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
                }
            } else if (-1 === $.inArray(position_array[j][0], other_1)) {
                select_html_1 = select_html_1 + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
            }

            if (position_array[j][0] === current_2) {
                select_html_2 = select_html_2 + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '" selected>' + position_array[j][1] + '</option>';
                if (captain_id === current_2) {
                    select_captain_html = select_captain_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '" selected>' + position_array[j][1] + '</option>';
                } else {
                    select_captain_html = select_captain_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
                }
            } else if (-1 === $.inArray(position_array[j][0], other_2)) {
                select_html_2 = select_html_2 + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
            }

            if (position_array[j][0] === current_3) {
                select_html_3 = select_html_3 + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '" selected>' + position_array[j][1] + '</option>';
                if (captain_id === current_3) {
                    select_captain_html = select_captain_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '" selected>' + position_array[j][1] + '</option>';
                } else {
                    select_captain_html = select_captain_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
                }
            } else if (-1 === $.inArray(position_array[j][0], other_3)) {
                select_html_3 = select_html_3 + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
            }

            if (position_array[j][0] === current_4) {
                select_html_4 = select_html_4 + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '" selected>' + position_array[j][1] + '</option>';
                if (captain_id === current_4) {
                    select_captain_html = select_captain_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '" selected>' + position_array[j][1] + '</option>';
                } else {
                    select_captain_html = select_captain_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
                }
            } else if (-1 === $.inArray(position_array[j][0], other_3)) {
                select_html_4 = select_html_4 + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
            }
        }

        $('#line-1-' + i).html(select_html_1);
        $('#line-2-' + i).html(select_html_2);
        $('#line-3-' + i).html(select_html_3);
        $('#line-4-' + i).html(select_html_4);
    }

    captainSelect.html(select_captain_html);

    player_change();
    if ($('.div-template-load')) {
        get_templates();
    }

    $('.lineup-change').on('change', function () {
        var position = parseInt($(this).data('position'));
        var line = parseInt($(this).data('line'));
        var player_id = parseInt($(this).val());
        var captain_id = parseInt(captainSelect.val());

        var player_id_array =
            [
                parseInt($('#line-0-0').val()),
                parseInt($('#line-1-0').val()),
                parseInt($('#line-1-1').val()),
                parseInt($('#line-2-1').val()),
                parseInt($('#line-3-1').val()),
                parseInt($('#line-4-1').val()),
                parseInt($('#line-1-2').val()),
                parseInt($('#line-2-2').val()),
                parseInt($('#line-3-2').val()),
                parseInt($('#line-4-2').val()),
                parseInt($('#line-1-3').val()),
                parseInt($('#line-2-3').val()),
                parseInt($('#line-3-3').val()),
                parseInt($('#line-4-3').val()),
                parseInt($('#line-1-4').val()),
                parseInt($('#line-2-4').val()),
                parseInt($('#line-3-4').val()),
                parseInt($('#line-4-4').val()),
                parseInt($('#line-1-5').val()),
                parseInt($('#line-2-5').val()),
                parseInt($('#line-3-5').val()),
                parseInt($('#line-4-5').val())
            ];

        if (0 === position) {
            position_array = gk_array;
        } else if (1 === position) {
            position_array = ld_array;
        } else if (2 === position) {
            position_array = rd_array;
        } else if (3 === position) {
            position_array = lw_array;
        } else if (4 === position) {
            position_array = cf_array;
        } else if (5 === position) {
            position_array = rw_array;
        }

        for (i = 0; i <= 1; i++) {
            position_array = gk_array;
            prompt = 'GK -';

            line_player = $('#line-' + i + '-0');
            line_player_id = parseInt(line_player.val());
            select_html = '<option value="0">' + prompt + '</option>';

            for (j = 0; j < position_array.length; j++) {
                if (position_array[j][0] === player_id) {
                    if (i === line && 0 === position) {
                        select_html = select_html + '<option selected value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
                    } else {
                        if (-1 === $.inArray(position_array[j][0], player_id_array)) {
                            select_html = select_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
                        }
                    }
                } else {
                    if (position_array[j][0] === line_player_id) {
                        select_html = select_html + '<option selected value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
                    } else {
                        if (-1 === $.inArray(position_array[j][0], player_id_array)) {
                            select_html = select_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
                        }
                    }
                }
            }

            line_player.html(select_html);
        }

        var select_captain_html = '<option value="0"></option>';

        for (var i = 1; i <= 4; i++) {
            for (var k = 1; k <= 5; k++) {
                if (1 === k) {
                    position_array = ld_array;
                    prompt = 'LD -';
                } else if (2 === k) {
                    position_array = rd_array;
                    prompt = 'RD -';
                } else if (3 === k) {
                    position_array = lw_array;
                    prompt = 'LW -';
                } else if (4 === k) {
                    position_array = cf_array;
                    prompt = 'CF -';
                } else if (5 === k) {
                    position_array = rw_array;
                    prompt = 'RW -';
                }

                line_player = $('#line-' + i + '-' + k);
                line_player_id = parseInt(line_player.val());
                select_html = '<option value="0">' + prompt + '</option>';

                for (var j = 0; j < position_array.length; j++) {
                    if (position_array[j][0] === player_id) {
                        if (i === line && k === position) {
                            select_html = select_html + '<option selected value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
                            if (captain_id === player_id) {
                                select_captain_html = select_captain_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '" selected>' + position_array[j][1] + '</option>';
                            } else {
                                select_captain_html = select_captain_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
                            }
                        } else {
                            if (-1 === $.inArray(position_array[j][0], player_id_array)) {
                                select_html = select_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
                            }
                        }
                    } else {
                        if (position_array[j][0] === line_player_id) {
                            select_html = select_html + '<option selected value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
                            if (captain_id === line_player_id) {
                                select_captain_html = select_captain_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '" selected>' + position_array[j][1] + '</option>';
                            } else {
                                select_captain_html = select_captain_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
                            }
                        } else {
                            if (-1 === $.inArray(position_array[j][0], player_id_array)) {
                                select_html = select_html + '<option value="' + position_array[j][0] + '" style="background-color: ' + position_array[j][2] + '">' + position_array[j][1] + '</option>';
                            }
                        }
                    }
                }

                line_player.html(select_html);
            }
        }

        captainSelect.html(select_captain_html);
    });

    $('.player-change').on('change', function () {
        player_change();
    });

    $('#template-save-submit').on('click', function () {
        $.ajax({
            'data': $('#template-save, #lineup-send').serialize(),
            'method': 'post',
            'url': $('#template-save').attr('action'),
            'complete': function () {
                get_templates();
                $('.div-template-save').hide(400);
                $('.div-template-load').show(400);
            }
        });
        return false;
    });

    $(document).on('click', '.template-delete', function () {
        $.ajax({
            'url': $(this).data('url'),
            'complete': function () {
                get_templates();
            }
        });
    });

    $(document).on('click', '.template-load', function () {
        $.ajax({
            'dataType': 'json',
            'url': $(this).data('url'),
            'success': function (data) {
                $('#gamesend-tactic_1').val(data.lineup_template_tactic_id_1);
                $('#gamesend-tactic_2').val(data.lineup_template_tactic_id_2);
                $('#gamesend-tactic_3').val(data.lineup_template_tactic_id_3);
                $('#gamesend-tactic_4').val(data.lineup_template_tactic_id_4);
                $('#gamesend-rudeness_1').val(data.lineup_template_rudeness_id_1);
                $('#gamesend-rudeness_2').val(data.lineup_template_rudeness_id_2);
                $('#gamesend-rudeness_3').val(data.lineup_template_rudeness_id_3);
                $('#gamesend-rudeness_4').val(data.lineup_template_rudeness_id_4);
                $('#gamesend-style_1').val(data.lineup_template_style_id_1);
                $('#gamesend-style_2').val(data.lineup_template_style_id_2);
                $('#gamesend-style_3').val(data.lineup_template_style_id_3);
                $('#gamesend-style_4').val(data.lineup_template_style_id_4);
                $('#line-0-0').val(data.lineup_template_player_gk_1);
                $('#line-1-0').val(data.lineup_template_player_gk_2);
                $('#line-1-1').val(data.lineup_template_player_ld_1);
                $('#line-1-2').val(data.lineup_template_player_rd_1);
                $('#line-1-3').val(data.lineup_template_player_lw_1);
                $('#line-1-4').val(data.lineup_template_player_cf_1);
                $('#line-1-5').val(data.lineup_template_player_rw_1);
                $('#line-2-1').val(data.lineup_template_player_ld_2);
                $('#line-2-2').val(data.lineup_template_player_rd_2);
                $('#line-2-3').val(data.lineup_template_player_lw_2);
                $('#line-2-4').val(data.lineup_template_player_cf_2);
                $('#line-2-5').val(data.lineup_template_player_rw_2);
                $('#line-3-1').val(data.lineup_template_player_ld_3);
                $('#line-3-2').val(data.lineup_template_player_rd_3);
                $('#line-3-3').val(data.lineup_template_player_lw_3);
                $('#line-3-4').val(data.lineup_template_player_cf_3);
                $('#line-3-5').val(data.lineup_template_player_rw_3);
                $('#line-4-1').val(data.lineup_template_player_ld_4);
                $('#line-4-2').val(data.lineup_template_player_rd_4);
                $('#line-4-3').val(data.lineup_template_player_lw_4);
                $('#line-4-4').val(data.lineup_template_player_cf_4);
                $('#line-4-5').val(data.lineup_template_player_rw_4).trigger('change');
                $('#captain').val(data.lineup_template_captain);
                player_change();
            }
        });
    });
});

function player_change() {
    $('.tr-player').removeClass('info');

    var player_change = $('.player-change');

    for (var i = 0; i < player_change.length; i++) {
        $('#tr-' + $(player_change[i]).val()).addClass('info');
    }

    send_ajax();
}

function send_ajax() {
    var form = $('.game-form');
    var form_data = form.serialize();
    var url = form.data('url');

    $.ajax({
        data: form_data,
        dataType: 'json',
        method: 'post',
        url: url,
        success: function (data) {
            $('.span-power').html(data.power);
            $('.span-position-percent').html(data.position);
            $('.span-lineup-percent').html(data.lineup);
            $('.span-teamwork-1').html(data.teamwork_1);
            $('.span-teamwork-2').html(data.teamwork_2);
            $('.span-teamwork-3').html(data.teamwork_3);
            $('.span-teamwork-4').html(data.teamwork_4);
        }
    });
}

function get_templates() {
    $.ajax({
        url: $('.div-template-load').data('url'),
        success: function (data) {
            $('.div-template-load').html(data);
        }
    });
}