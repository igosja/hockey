<?php
/**
 * @var $news_array array
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <form id="news-form" method="POST">
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
                    <label for="newstitle">Заголовок новости:</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input class="form-control" id="newstitle" name="data[title]" value="<?= $news_array[0]['news_title']; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center newstitle-error notification-error"></div>
            </div>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
                    <label for="newstext">Текст новости:</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-2">
                    Используйте [bb]-коды:
                    <ul>
                        <li>[p]Новый абзац[/p]</li>
                        <li>[table][tr][th]Вставка[/th][/tr][tr][td]таблицы[/td][/tr][/table]</li>
                        <li>[ul][li]Список[/li][/ul]</li>
                        <li>[b]Полужирный текст[/b]</li>
                        <li>[i]Курсивный текст[/i]</li>
                        <li>[u]Подчеркнутый текст[/u]</li>
                        <li>[s]Зачеркнутый текст[/s]</li>
                        <li>[link="url"]Cсылка[/link]</li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <textarea class="form-control" id="newstext" name="data[text]" rows="5"><?= $news_array[0]['news_text']; ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center newstext-error notification-error"></div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <button class="btn margin">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>