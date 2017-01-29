<?php include (__DIR__ . '/include/country_view.php'); ?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Команда</th>
            </tr>
            <?php foreach ($team_array as $item) { ?>
                <tr <?php if (isset ($auth_team_id) && $auth_team_id == $item['team_id']) { ?>class="current"<?php } ?>>
                    <td>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>