<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                Ваша команда:
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <span class="strong">
                                <a href="/team_view.php?num=<?= 1; ?>">
                                    <?= 1; ?>
                                    <span class="hidden-xs">
                                        (<?= 2; ?>, <?= 3; ?>)
                                    </span>
                                </a>
                            </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                В кассе команды:
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <span class="strong"><?= 1; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                Начальная цена:
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <span class="strong"><?= 2; ?></span>
            </div>
        </div>
        <form method="POST">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                    <label for="price">Ваше предложение, $:</label>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-2 col-xs-6">
                    <input class="form-control" name="data[price]" id="price" type="text" value="<?= 4; ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <label for="only_one">
                        В случае победы удалить все остальные мои заявки
                        <input name="data[only_one]" type="hidden" value="0"/>
                        <input name="data[only_one]" id="only_one" type="checkbox" value="1"
                               <?php if (1 == 1) { ?>checked<?php } ?> />
                    </label>
                </div>
            </div>
            <p class="text-center">
                <?php if (1) { ?>
                    <button class="btn" type="submit">
                        Редактировать заявку
                    </button>
                    <a href="?num=<?= 2; ?>&data[off]=1" class="btn">Удалить заявку</a>
                <?php } else { ?>
                    <button class="btn" type="submit">
                        Подать заявку
                    </button>
                <?php } ?>
            </p>
        </form>
    </div>
</div>