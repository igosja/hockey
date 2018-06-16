<?php
/**
 * @var $leaguedistribution_array array
 * @var $season_array array
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-20">Сезон</th>
                <th class="col-20">Групповой этап</th>
                <th class="col-20">ОР3</th>
                <th class="col-20">ОР2</th>
                <th class="col-20">ОР1</th>
            </tr>
            <?php foreach ($leaguedistribution_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['leaguedistribution_season_id']; ?></td>
                    <td class="text-center"><?= $item['leaguedistribution_group']; ?></td>
                    <td class="text-center"><?= $item['leaguedistribution_qualification_3']; ?></td>
                    <td class="text-center"><?= $item['leaguedistribution_qualification_2']; ?></td>
                    <td class="text-center"><?= $item['leaguedistribution_qualification_1']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Сезон</th>
                <th>Групповой этап</th>
                <th>ОР3</th>
                <th>ОР2</th>
                <th>ОР1</th>
            </tr>
        </table>
    </div>
</div>
<?php foreach ($season_array as $season) { ?>
    <div class="row margin-top-small">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
            <?= $season['participantleague_season_id']; ?> сезон
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Команда</th>
                    <th class="col-20">Стадия</th>
                    <th class="col-5" title="Победы">В</th>
                    <th class="col-5" title="Победы в овертайте/по буллитам">ВО</th>
                    <th class="col-5" title="Ничьи и поражения в овертайте/по буллитам">Н/ПО</th>
                    <th class="col-5" title="Поражения">П</th>
                    <th class="col-5" title="Очки">О</th>
                </tr>
                <?php foreach ($season['team'] as $item) { ?>
                    <tr>
                        <td>
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                                <span class="hidden-xs">(<?= $item['city_name']; ?>)</span>
                            </a>
                        </td>
                        <td class="text-center"><?= $item['stage_name']; ?></td>
                        <td class="text-center"><?= $item['leaguecoefficient_win']; ?></td>
                        <td class="text-center"><?= $item['leaguecoefficient_win_over']; ?></td>
                        <td class="text-center"><?= $item['leaguecoefficient_loose_over']; ?></td>
                        <td class="text-center"><?= $item['leaguecoefficient_loose']; ?></td>
                        <td class="text-center strong"><?= $item['leaguecoefficient_point']; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Команда</th>
                    <th>Стадия</th>
                    <th title="Победы">В</th>
                    <th title="Победы в овертайте/по буллитам">ВО</th>
                    <th title="Поражения в овертайте/по буллитам">ПО</th>
                    <th title="Поражения">П</th>
                    <th title="Очки">О</th>
                </tr>
            </table>
        </div>
    </div>
<?php } ?>