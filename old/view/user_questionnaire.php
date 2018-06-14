<?php
/**
 * @var $country_array array
 * @var $questionnaire_array array
 * @var $sex_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/user_profile_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                Анкетные данные
            </div>
        </div>
        <?php include(__DIR__ . '/include/user_profile_top_right.php'); ?>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/user_table_link.php'); ?>
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
<form method="POST" id="questionnaire-form">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            На этой странице вы можете <span class="strong">изменить свои анкетные данные</span>:
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label for="questionnaire-name">Имя</label>:
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <input
                class="form-control form-small"
                id="questionnaire-name"
                name="data[user_name]"
                value="<?= $questionnaire_array[0]['user_name']; ?>"
            />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label for="questionnaire-surname">Фамилия</label>:
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <input
                class="form-control form-small"
                id="questionnaire-surname"
                name="data[user_surname]"
                value="<?= $questionnaire_array[0]['user_surname']; ?>"
            />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label for="questionnaire-email">Email</label>:
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <input
                class="form-control form-small"
                id="questionnaire-email"
                name="data[user_email]"
                value="<?= $questionnaire_array[0]['user_email']; ?>"
            />
        </div>
        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12 xs-text-center questionnaire-email-error notification-error"></div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label for="questionnaire-city">Город</label>:
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <input
                class="form-control form-small"
                id="questionnaire-city"
                name="data[user_city]"
                value="<?= $questionnaire_array[0]['user_city']; ?>"
            />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label for="questionnaire-country">Страна</label>:
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <select class="form-control form-small" id="questionnaire-country" name="data[user_country_id]">
                <option value="0">Не указано</option>
                <?php foreach ($country_array as $item) { ?>
                    <option
                        <?php if ($item['country_id'] == $questionnaire_array[0]['user_country_id']) { ?>
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
        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label for="questionnaire-sex">Пол</label>:
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <select class="form-control form-small" id="questionnaire-sex" name="data[user_sex_id]">
                <option value="0">Не указано</option>
                <?php foreach ($sex_array as $item) { ?>
                    <option
                        <?php if ($item['sex_id'] == $questionnaire_array[0]['user_sex_id']) { ?>
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
        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label for="questionnaire-birth">Дата рождения</label>:
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <select class="form-control form-small" id="questionnaire-birth" name="data[user_birth_day]">
                        <option value="0">Не указано</option>
                        <?php for ($i = 1; $i <= 31; $i++) { ?>
                            <option
                                <?php if ($i == $questionnaire_array[0]['user_birth_day']) { ?>
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
                    <label class="hidden" for="questionnaire-birth-1"></label>
                    <select class="form-control form-small" id="questionnaire-birth-1" name="data[user_birth_month]">
                        <option value="0">Не указано</option>
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <option
                                <?php if ($i == $questionnaire_array[0]['user_birth_month']) { ?>
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
                    <label class="hidden" for="questionnaire-birth-2"></label>
                    <select class="form-control form-small" id="questionnaire-birth-2" name="data[user_birth_year]">
                        <option value="0">Не указано</option>
                        <?php for ($i = date('Y'); $i >= date('Y') - 100; $i--) { ?>
                            <option
                                <?php if ($i == $questionnaire_array[0]['user_birth_year']) { ?>
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
        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label for="bb">
                Использовать текстовый редактор
            </label>
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <input name="data[user_use_bb]" type="hidden" value="0" />
            <input
                    id="bb"
                    name="data[user_use_bb]"
                    type="checkbox"
                    value="1"
                <?php if ($questionnaire_array[0]['user_use_bb']) { ?>
                    checked
                <?php } ?>
            />
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