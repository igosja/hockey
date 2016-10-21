<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                Имя
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                Последний визит: <?= f_igosja_ufu_last_visit($user_array[0]['user_date_login']); ?>
            </div>
        </div>
        <div class="row text-size-4"><?= SPACE; ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Ник: <span class="strong"><?= $user_array[0]['user_login']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Личный счет: <span class="strong"><?= f_igosja_money($user_array[0]['user_finance']); ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Денежный счет: <span class="strong"><?= $user_array[0]['user_money']; ?> ед.</span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Рейтинг: 0
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                VIP-клуб: 0
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                Профиль менеджера
            </div>
        </div>
        <div class="row text-size-4"><?= SPACE; ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                День рождения:
                <span class="strong"><?= f_igosja_birth_date($user_array[0]); ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Пол: <span class="strong"><?= $user_array[0]['sex_name']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Откуда: <span class="strong"><?= f_igosja_user_from($user_array[0]); ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Дата регистрации:
                <span class="strong"><?= f_igosja_ufu_date($user_array[0]['user_date_register']); ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row text-size-4"><?= SPACE; ?></div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table">
            <tr>
                <th>Изменение анкетных данных менеджера</th>
            </tr>
        </table>
    </div>
</div>
<form method="POST">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            На этой странице вы можете <span class="strong">изменить свои анкетные данные</span>:
        </div>
    </div>
    <?php if (isset($success)) { ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center success">
            <?= $success; ?>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <label for="questionnaire-name">Имя</label>:
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text-left">
            <input
                class="form-control form-small"
                id="questionnaire-name"
                name="data[user_name]"
                type="text"
                value="<?= $user_array[0]['user_name']; ?>"
            />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <label for="questionnaire-surname">Фамилия</label>:
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text-left">
            <input
                class="form-control form-small"
                id="questionnaire-surname"
                name="data[user_surname]"
                type="text"
                value="<?= $user_array[0]['user_surname']; ?>"
            />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <label for="questionnaire-email">Email</label>:
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text-left">
            <input
                class="form-control form-small"
                id="questionnaire-email"
                name="data[user_email]"
                type="text"
                value="<?= $user_array[0]['user_email']; ?>"
            />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <label for="questionnaire-city">Город</label>:
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text-left">
            <input
                class="form-control form-small"
                id="questionnaire-city"
                name="data[user_city]"
                type="text"
                value="<?= $user_array[0]['user_city']; ?>"
            />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <label for="questionnaire-country">Страна</label>:
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text-left">
            <select class="form-control form-small" id="questionnaire-country" name="data[user_country_id]">
                <option value="0">Не указано</option>
                <?php foreach ($country_array as $item) { ?>
                    <option
                        <?php if ($item['country_id'] == $user_array[0]['user_country_id']) { ?>
                            selected
                        <?php } ?>
                        value="<?= $item['country_id']; ?>"
                    >
                        <?= $item['country_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <label for="questionnaire-sex">Пол</label>:
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text-left">
            <select class="form-control form-small" id="questionnaire-sex" name="data[user_sex_id]">
                <option value="0">Не указано</option>
                <?php foreach ($sex_array as $item) { ?>
                    <option
                        <?php if ($item['sex_id'] == $user_array[0]['user_sex_id']) { ?>
                            selected
                        <?php } ?>
                        value="<?= $item['sex_id']; ?>"
                    >
                        <?= $item['sex_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <label for="questionnaire-birth">Дата рождения</label>:
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text-left">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <select class="form-control form-small" id="questionnaire-birth" name="data[user_birth_day]">
                        <option value="0">Не указано</option>
                        <?php for ($i = 1; $i <= 31; $i++) { ?>
                            <option
                                <?php if ($i == $user_array[0]['user_birth_day']) { ?>
                                    selected
                                <?php } ?>
                                value="<?= $i; ?>"
                            >
                                <?= $i; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <select class="form-control form-small" name="data[user_birth_month]">
                        <option value="0">Не указано</option>
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <option
                                <?php if ($i == $user_array[0]['user_birth_month']) { ?>
                                    selected
                                <?php } ?>
                                value="<?= $i; ?>"
                            >
                                <?= $i; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <select class="form-control form-small" name="data[user_birth_year]">
                        <option value="0">Не указано</option>
                        <?php for ($i = date('Y'); $i >= date('Y') - 100; $i--) { ?>
                            <option
                                <?php if ($i == $user_array[0]['user_birth_year']) { ?>
                                    selected
                                <?php } ?>
                                value="<?= $i; ?>"
                            >
                                <?= $i; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <label for="questionnaire-holiday">Я уехал в отпуск</label>:
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text-left">
            <input
                <?php if ($user_array[0]['user_holiday']) { ?>
                    checked
                <?php } ?>
                id="questionnaire-holiday"
                name="data[user_holiday]"
                type="checkbox"
            /> Назначить заместитетей
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center text-size-3">
            Если вы поменяете свой e-mail, система автоматически отправит письмо на новый адрес с указанием,
            как подтвердить, что ящик принадлежит вам и работает
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button type="submit" class="btn">
                Сохранить
            </button>
        </div>
    </div>
</form>