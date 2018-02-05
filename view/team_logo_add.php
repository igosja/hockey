<?php
/**
 * @var $logo_array array
 * @var $num_get integer
 * @var $team_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>Загрузить эмблему</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                <div class="row">
                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                        <span class="strong">Старая эмблема</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 team-logo-div">
                        <span class="team-logo-link">
                            <?php if (file_exists(__DIR__ . '/../img/team/125/' . $num_get . '.png')) { ?>
                                <img
                                    alt="<?= $team_array[0]['team_name']; ?>"
                                    class="team-logo"
                                    src="/img/team/125/<?= $num_get; ?>.png"
                                    title="<?= $team_array[0]['team_name']; ?>"
                                />
                            <?php } else { ?>
                                Нет эмблемы
                            <?php } ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="row">
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                        <span class="strong">Новая эмблема</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 team-logo-div">
                        <span class="team-logo-link">
                            <?php if (file_exists(__DIR__ . '/../upload/img/team/125/' . $num_get . '.png')) { ?>
                                <img
                                    alt="<?= $team_array[0]['team_name']; ?>"
                                    class="team-logo"
                                    src="/upload/img/team/125/<?= $num_get; ?>.png"
                                    title="<?= $team_array[0]['team_name']; ?>"
                                />
                            <?php } else { ?>
                                Нет эмблемы
                            <?php } ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" id="team-logo-form" enctype="multipart/form-data">
            <div class="row margin-top">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                    Команда:
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <?= $team_array[0]['team_name']; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                    <label for="logo">Эмблема:</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input id="logo" name="data[logo]" type="file"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center logo-error notification-error"></div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                    Чем новая эмблема лучше старой:
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <textarea class="form-control" id="text" name="data[text]"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center text-error notification-error"></div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs"></div>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                    <ul>
                        <li>Эмблемы должны быть "плоскими", а не "с эффектом объёма".</li>
                        <li>Фон эмблемы должен быть прозрачный.</li>
                        <li>Размер картинки: 100x125 пикселей.</li>
                        <li>Формат картинки: png.</li>
                        <li>Объем файла: не более 50 килобайт.</li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <input class="btn margin" type="submit" value="Отправить файл">
                    <a class="btn margin" href="/team_view.php?num=<?= $num_get; ?>">
                        Вернуться в ростер команды
                    </a>
                </div>
            </div>
        </form>
        <?php if ($logo_array) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    Список команд, чьи эмблемы находятся в процессе проверки (<?= count($logo_array); ?>):
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs"></div>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                    <ul>
                        <?php foreach ($logo_array as $item) { ?>
                            <li>
                                <img
                                    alt="<?= $item['country_name']; ?>"
                                    src="/img/country/12/<?= $item['country_id']; ?>.png"
                                    title="<?= $item['country_name']; ?>"
                                />
                                <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                    <?= $item['team_name']; ?> (<?= $item['city_name']; ?>)
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</div>