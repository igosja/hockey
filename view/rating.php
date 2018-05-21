<?php
/**
 * @var $count_ratingtype integer
 * @var $igosja_season_id integer
 * @var $num_get integer
 * @var $rating_array array
 * @var $ratingtype_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Рейтинги
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <form action="/rating.php" method="GET">
            <label for="ratingtype">Рейтинг</label>
            <select class="form-control submit-on-change" id="ratingtype" name="num">
                <?php for ($i=0; $i<$count_ratingtype; $i++) { ?>
                    <?php if (0 == $i || $ratingtype_array[$i]['ratingchapter_name'] != $ratingtype_array[$i-1]['ratingchapter_name']) { ?>
                        <optgroup label="<?= $ratingtype_array[$i]['ratingchapter_name']; ?>">
                    <?php } ?>
                        <option
                            value="<?= $ratingtype_array[$i]['ratingtype_id']; ?>"
                            <?php if ($num_get == $ratingtype_array[$i]['ratingtype_id']) { ?>
                                selected
                            <?php } ?>
                        >
                            <?= $ratingtype_array[$i]['ratingtype_name']; ?>
                        </option>
                    <?php if ($count_ratingtype == $i+1 || $ratingtype_array[$i]['ratingchapter_name'] != $ratingtype_array[$i+1]['ratingchapter_name']) { ?>
                        </optgroup>
                    <?php } ?>
                <?php } ?>
            </select>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if (RATING_TEAM_POWER == $num_get) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th title="Сумма сил 16 лучших игроков">s16</th>
                    <th title="Сумма сил 21 лучших игроков">s21</th>
                    <th title="Сумма сил 27 лучших игроков">s27</th>
                    <th title="Сила команды в длительных соревнованиях">Vs</th>
                </tr>
                <?php foreach ($rating_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['ratingteam_power_vs_place']; ?></td>
                        <td>
                            <img src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>"/>
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                                (<?= $item['city_name']; ?>)
                            </a>
                        </td>
                        <td class="text-center"><?= $item['team_power_s_16']; ?></td>
                        <td class="text-center"><?= $item['team_power_s_21']; ?></td>
                        <td class="text-center"><?= $item['team_power_s_27']; ?></td>
                        <td class="text-center"><?= $item['team_power_vs']; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th title="Сумма сил 16 лучших игроков">s16</th>
                    <th title="Сумма сил 21 лучших игроков">s21</th>
                    <th title="Сумма сил 27 лучших игроков">s27</th>
                    <th title="Сила команды в длительных соревнованиях">Vs</th>
                </tr>
            </table>
        <?php } elseif (RATING_TEAM_AGE == $num_get) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th title="Средний возраст">В</th>
                </tr>
                <?php foreach ($rating_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['ratingteam_age_place']; ?></td>
                        <td>
                            <img src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>"/>
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                                (<?= $item['city_name']; ?>)
                            </a>
                        </td>
                        <td class="text-center"><?= $item['team_age']; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th title="Средний возраст">В</th>
                </tr>
            </table>
        <?php } elseif (RATING_TEAM_STADIUM == $num_get) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th>Вместимость</th>
                </tr>
                <?php foreach ($rating_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['ratingteam_stadium_place']; ?></td>
                        <td>
                            <img src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>"/>
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                                (<?= $item['city_name']; ?>)
                            </a>
                        </td>
                        <td class="text-center"><?= $item['stadium_capacity']; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th>Вместимость</th>
                </tr>
            </table>
        <?php } elseif (RATING_TEAM_VISITOR == $num_get) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th>Помещаемость</th>
                </tr>
                <?php foreach ($rating_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['ratingteam_visitor_place']; ?></td>
                        <td>
                            <img src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>"/>
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                                (<?= $item['city_name']; ?>)
                            </a>
                        </td>
                        <td class="text-center"><?= $item['team_visitor']; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th>Помещаемость</th>
                </tr>
            </table>
        <?php } elseif (RATING_TEAM_BASE == $num_get) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th title="База">Б</th>
                    <th title="Количество построек">П</th>
                    <th title="Тренировочная база">Т</th>
                    <th title="Медицинский центр">М</th>
                    <th title="Физцентр">Ф</th>
                    <th title="Спротшкола">Сп</th>
                    <th title="Скаутцентр">Ск</th>
                </tr>
                <?php foreach ($rating_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['ratingteam_base_place']; ?></td>
                        <td>
                            <img src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>"/>
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                                (<?= $item['city_name']; ?>)
                            </a>
                        </td>
                        <td class="text-center"><?= $item['base_level']; ?></td>
                        <td class="text-center">
                            <?= $item['basetraining_level']
                            + $item['basemedical_level']
                            + $item['basephisical_level']
                            + $item['baseschool_level']
                            + $item['basescout_level']; ?>
                        </td>
                        <td class="text-center"><?= $item['basetraining_level']; ?></td>
                        <td class="text-center"><?= $item['basemedical_level']; ?></td>
                        <td class="text-center"><?= $item['basephisical_level']; ?></td>
                        <td class="text-center"><?= $item['baseschool_level']; ?></td>
                        <td class="text-center"><?= $item['basescout_level']; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th title="База">Б</th>
                    <th title="Количество построек">П</th>
                    <th title="Тренировочная база">Т</th>
                    <th title="Медицинский центр">М</th>
                    <th title="Физцентр">Ф</th>
                    <th title="Спротшкола">Сп</th>
                    <th title="Скаутцентр">Ск</th>
                </tr>
            </table>
        <?php } elseif (RATING_TEAM_PRICE_BASE == $num_get) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th>База</th>
                </tr>
                <?php foreach ($rating_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['ratingteam_price_base_place']; ?></td>
                        <td>
                            <img src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>"/>
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                                (<?= $item['city_name']; ?>)
                            </a>
                        </td>
                        <td class="text-center"><?= f_igosja_money_format($item['team_price_base']); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th>База</th>
                </tr>
            </table>
        <?php } elseif (RATING_TEAM_PRICE_STADIUM == $num_get) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th>Стадион</th>
                </tr>
                <?php foreach ($rating_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['ratingteam_price_stadium_place']; ?></td>
                        <td>
                            <img src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>"/>
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                                (<?= $item['city_name']; ?>)
                            </a>
                        </td>
                        <td class="text-center"><?= f_igosja_money_format($item['team_price_stadium']); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th>В кассе</th>
                </tr>
            </table>
        <?php } elseif (RATING_TEAM_PLAYER == $num_get) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th>Количество</th>
                    <th>Стоимость</th>
                    <th>Зарплата</th>
                </tr>
                <?php foreach ($rating_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['ratingteam_player_place']; ?></td>
                        <td>
                            <img src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>"/>
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                                (<?= $item['city_name']; ?>)
                            </a>
                        </td>
                        <td class="text-center"><?= $item['team_player']; ?></td>
                        <td class="text-center"><?= f_igosja_money_format($item['team_price_player']); ?></td>
                        <td class="text-center"><?= f_igosja_money_format($item['team_salary']); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th>Количество</th>
                    <th>Стоимость</th>
                    <th>Зарплата</th>
                </tr>
            </table>
        <?php } elseif (RATING_TEAM_PRICE_TOTAL == $num_get) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th>База</th>
                    <th>Стадион</th>
                    <th>Игроки</th>
                    <th>В кассе</th>
                    <th>Стоимость</th>
                </tr>
                <?php foreach ($rating_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['ratingteam_price_total_place']; ?></td>
                        <td>
                            <img src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>"/>
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                                (<?= $item['city_name']; ?>)
                            </a>
                        </td>
                        <td class="text-center"><?= f_igosja_money_format($item['team_price_base']); ?></td>
                        <td class="text-center"><?= f_igosja_money_format($item['team_price_stadium']); ?></td>
                        <td class="text-center"><?= f_igosja_money_format($item['team_price_player']); ?></td>
                        <td class="text-center"><?= f_igosja_money_format($item['team_finance']); ?></td>
                        <td class="text-center"><?= f_igosja_money_format($item['team_price_total']); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th>База</th>
                    <th>Стадион</th>
                    <th>Игроки</th>
                    <th>В кассе</th>
                    <th>Стоимость</th>
                </tr>
            </table>
        <?php } elseif (RATING_USER_RATING == $num_get) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Менеджер</th>
                    <th title="Страна" class="col-1">С</th>
                    <th>Рейтинг</th>
                </tr>
                <?php foreach ($rating_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['ratinguser_rating_place']; ?></td>
                        <td>
                            <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                                <?= $item['user_login']; ?>
                            </a>
                        </td>
                        <td>
                            <?php if ($item['country_id']) { ?>
                                <img src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>"/>
                            <?php } ?>
                        </td>
                        <td class="text-center"><?= $item['user_rating']; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Менеджер</th>
                    <th title="Страна">С</th>
                    <th>Рейтинг</th>
                </tr>
            </table>
        <?php } elseif (RATING_COUNTRY_STADIUM == $num_get) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Страна</th>
                    <th>10 лучших</th>
                </tr>
                <?php foreach ($rating_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['ratingcountry_stadium_place']; ?></td>
                        <td>
                            <img src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>"/>
                            <a href="/country_news.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="text-center">
                            <?= number_format($item['country_stadium'], 0, '.', ' '); ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Страна</th>
                    <th>10 лучших</th>
                </tr>
            </table>
        <?php } elseif (RATING_COUNTRY_AUTO == $num_get) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Страна</th>
                    <th title="Игры">И</th>
                    <th title="Автосоставы">А</th>
                    <th>%</th>
                </tr>
                <?php foreach ($rating_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['ratingcountry_auto_place']; ?></td>
                        <td>
                            <img src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>"/>
                            <a href="/country_news.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="text-center"><?= $item['country_game']; ?></td>
                        <td class="text-center"><?= $item['country_auto']; ?></td>
                        <td class="text-center">
                            <?= number_format(
                                round($item['country_auto'] / ($item['country_game'] ? $item['country_game'] : 1) * 100, 2),
                                2,
                                '.',
                                ' '
                            ); ?>%
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Страна</th>
                    <th title="Игры">И</th>
                    <th title="Автосоставы">А</th>
                    <th>%</th>
                </tr>
            </table>
        <?php } elseif (RATING_COUNTRY_LEAGUE == $num_get) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Страна</th>
                    <th title="Сезон <?= $igosja_season_id; ?>"><?= $igosja_season_id; ?></th>
                    <th title="Сезон <?= $igosja_season_id - 1; ?>"><?= $igosja_season_id - 1; ?></th>
                    <th title="Коэффициент">К</th>
                </tr>
                <?php foreach ($rating_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['ratingcountry_league_place']; ?></td>
                        <td>
                            <img src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>"/>
                            <a href="/country_news.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="text-center"><?= $item['leaguecoefficient_coeff_1']; ?></td>
                        <td class="text-center"><?= $item['leaguecoefficient_coeff_2']; ?></td>
                        <td class="text-center">
                            <?= number_format(
                                $item['leaguecoefficient_coeff_1'] +
                                $item['leaguecoefficient_coeff_2'] +
                                $item['leaguecoefficient_coeff_3'] +
                                $item['leaguecoefficient_coeff_4'] +
                                $item['leaguecoefficient_coeff_5'],
                                4,
                                '.',
                                ' '
                            ); ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Страна</th>
                    <th title="Сезон <?= $igosja_season_id; ?>"><?= $igosja_season_id; ?></th>
                    <th title="Сезон <?= $igosja_season_id - 1; ?>"><?= $igosja_season_id - 1; ?></th>
                    <th title="Коэффициент">К</th>
                </tr>
            </table>
        <?php } ?>
    </div>
</div>