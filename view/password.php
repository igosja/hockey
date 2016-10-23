<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Забыли пароль?</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <a href="/signup.php">Регистрация</a> | <strong>Забыли пароль?</strong> | <a href="/activation.php">Активация аккаунта</a>
    </div>
</div>
<form method="POST">
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
                <div class="col-lg-5 col-md-4 col-sm-4 hidden-xs text-right">
                    <label class="strong" for="password-login">Логин:</label>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center">
                    <label class="strong" for="password-login">Логин:</label>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                    <input
                        class="form-control"
                        id="password-login"
                        name="data[login]"
                        type="text"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-4 col-sm-4 hidden-xs text-right">
                    <label class="strong" for="password-email">Email:</label>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center">
                    <label class="strong" for="password-email">Email:</label>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                    <input
                        class="form-control"
                        id="password-email"
                        name="data[email]"
                        type="email"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p>
                Если при регистрации вы ввели свой e-mail неправильно или он уже не работает,<br/>
                то напишите нам письмо на <?= EMAIL_INFO; ?><br/>
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