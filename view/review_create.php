<?php
/**
 * @var $country_array array
 * @var $game_array array
 * @var $season_id integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            <?= $country_array[0]['country_name']; ?>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Сезон <?= $season_id; ?>, <?= $country_array[0]['division_name']; ?>, <?= $game_array[0]['stage_name']; ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table">
            <?php foreach ($game_array as $item) { ?>
                <tr>
                    <td class="text-right col-45">
                        <a href="/team_view.php?num=<?= $item['home_team_id']; ?>">
                            <?= $item['home_team_name']; ?>
                            <span class="hidden-xs">(<?= $item['home_city_name']; ?>)</span>
                        </a>
                        <?= f_igosja_game_auto($item['game_home_auto']); ?>
                    </td>
                    <td class="text-center col-10">
                        <a href="/game_view.php?num=<?= $item['game_id']; ?>">
                            <?= f_igosja_game_score($item['game_played'], $item['game_home_score'], $item['game_guest_score']); ?>
                        </a>
                    </td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['guest_team_id']; ?>">
                            <?= $item['guest_team_name']; ?>
                            <span class="hidden-xs">(<?= $item['guest_city_name']; ?>)</span>
                        </a>
                        <?= f_igosja_game_auto($item['game_guest_auto']); ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p class="text-justify">
            Текст обзора должен быть информативным, выдержанным в тоне публикаций в спортивных СМИ,
            освещать все матчи игрового дня в дивизионе, не должен содержать бурного выражения личных эмоций,
            ненормативной лексики и оскорблений в чей-либо адрес,
            не должен являться ответом на другой обзор или высказывание участника игры.
        </p>
        <p class="text-justify">
            Будьте внимательны! Обзор нельзя отредактировать после сохранения.
        </p>
    </div>
</div>
<form method="POST">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 text-right">
            <label for="title">Заголовок:</label>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-8">
            <input class="form-control" id="title" name="data[title]"/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center title-error notification-error"></div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label class="hidden" for="text"></label>
            <textarea class="form-control" id="text" name="data[text]" rows="20"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center text-error notification-error"></div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <input class="btn margin" type="submit" value="Создать">
        </div>
    </div>
</form>