<?php
/**
 * @var $country_array array
 * @var $division_array array
 * @var $season_array array
 * @var $season_id integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Турниры
        </h1>
    </div>
</div>
<form method="GET">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
            <label for="season_id">Сезон:</label>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <select class="form-control submit-on-change" name="season_id" id="season_id">
                <?php foreach ($season_array as $item) { ?>
                    <option
                            value="<?= $item['season_id']; ?>"
                        <?php if ($season_id == $item['season_id']) { ?>
                            selected
                        <?php } ?>
                    >
                        <?= $item['season_id']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
    </div>
</form>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <a href="/offseason.php?season_id=<?= $season_id; ?>">Кубок межсезонья</a>
        |
        <a href="/conference.php?season_id=<?= $season_id; ?>">Конференция</a>
        |
        <a href="/worldcup.php?season_id=<?= $season_id; ?>">Чемпионат мира</a>
        |
        <a href="/league.php?season_id=<?= $season_id; ?>">Лига чемпионов</a>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-hover">
            <tr>
                <th colspan="5">Национальные чемпионаты</th>
            </tr>
            <?php foreach ($country_array as $item) { ?>
                <tr>
                    <td>
                        <a href="/country_team.php?num=<?= $item['country_id']; ?>">
                            <?= $item['country_name']; ?>
                        </a>
                    </td>
                    <?php foreach ($item['division'] as $key => $value) { ?>
                        <td class="text-center col-10">
                            <?php if ('-' == $value) { ?>
                                -
                            <?php } else { ?>
                                <a href="/championship.php?country_id=<?= $item['country_id']; ?>&division_id=<?= $key; ?>&season_id=<?= $season_id; ?>">
                                    <?= $value; ?>
                                </a>
                            <?php } ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            <tr>
                <th colspan="5">Национальные чемпионаты</th>
            </tr>
        </table>
    </div>
</div>