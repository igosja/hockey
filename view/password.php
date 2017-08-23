<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Забыли пароль?</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/register_link.php'); ?>
    </div>
</div>
<form id="password-form" method="POST">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p>
                Здесь вы можете запросить отправку <strong>забытого пароля на свой почтовый ящик</strong>,
                который был указан вами при регистрации.
            </p>
            <p>
                Укажите ваш <strong>логин</strong> или <strong>email</strong>:
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
                    <label class="strong" for="password-login">Логин:</label>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                    <input
                        class="form-control"
                        id="password-login"
                        name="data[login]"
                    />
                </div>
                <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12 xs-text-center password-error notification-error"></div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
                    <label class="strong" for="password-email">Email:</label>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                    <input
                        class="form-control"
                        id="password-email"
                        name="data[email]"
                    />
                </div>
                <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12 xs-text-center password-email-error notification-error"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p>
                Если при регистрации вы ввели свой e-mail неправильно или он уже не работает,<br/>
                то напишите нам письмо на <span class="strong"><?= EMAIL_INFO; ?></span><br/>
                и мы попробуем найти ваш аккаунт вручную.
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button type="submit" class="btn">
                Восстановить пароль
            </button>
        </div>
    </div>
</form>