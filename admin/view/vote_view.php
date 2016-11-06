<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $vote_array[0]['vote_text']; ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <?php if (1 == $vote_array[0]['vote_votestatus_id']) { ?>
        <li>
            <a href="/admin/vote_ok.php?num=<?= $num_get; ?>">
                <button class="btn btn-default">Одобрить</button>
            </a>
        </li>
    <?php } ?>
    <li>
        <a href="/admin/vote_list.php">
            <button class="btn btn-default">Список</button>
        </a>
    </li>
    <li>
        <a href="/admin/vote_update.php?num=<?= $num_get; ?>">
            <button class="btn btn-default">Изменить</button>
        </a>
    </li>
    <li>
        <a href="/admin/vote_delete.php?num=<?= $num_get; ?>">
            <button class="btn btn-default">Удалить</button>
        </a>
    </li>
</ul>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Id
                </td>
                <td>
                    <?= $vote_array[0]['vote_id']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Вопрос
                </td>
                <td>
                    <?= $vote_array[0]['vote_text']; ?>
                </td>
            </tr>
            <?php foreach ($vote_array as $item) { ?>
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Ответ
                    </td>
                    <td>
                        <?= $item['voteanswer_text']; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>