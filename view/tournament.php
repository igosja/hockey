<?php
/**
 * @var $country_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Турниры
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <a href="/offseason.php">Кубок межсезонья</a>
        |
        <a href="/conference.php">Конференция</a>
        |
        <a href="/worldcup.php">Чемпионат мира</a>
        |
        <a href="/league.php">Лига чемпионов</a>
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
                                <a href="/championship.php?country_id=<?= $item['country_id']; ?>&division_id=<?= $value; ?>">
                                    <?= $key; ?>
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