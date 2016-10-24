<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">
            <?php if (isset($news_array[0]['news_title'])) { ?>
                <?= $news_array[0]['news_title']; ?>
            <?php } else { ?>
                Создание новости
            <?php } ?>
        </h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a href="/admin/news_list.php">
            <button class="btn btn-default">Список</button>
        </a>
    </li>
    <?php if (isset($num_get)) { ?>
        <li>
            <a href="/admin/news_view.php?num=<?= $num_get; ?>">
                <button class="btn btn-default">Просмотр</button>
            </a>
        </li>
    <?php } ?>
</ul>
<form class="form-horizontal" method="POST">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label" for="news_title">Название</label>
                    </td>
                    <td>
                        <input
                            class="form-control"
                            id="news_title"
                            name="data[news_title]"
                            value="<?= isset($news_array[0]['news_title']) ? $news_array[0]['news_title'] : ''; ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label" for="news_text">Текст</label>
                    </td>
                    <td>
                        <textarea
                            class="form-control"
                            id="news_text"
                            name="data[news_text]"
                            rows="10"
                        ><?= isset($news_array[0]['news_text']) ? $news_array[0]['news_text'] : ''; ?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button class="btn btn-default" type="submit">Сохранить</button>
        </div>
    </div>
</form>