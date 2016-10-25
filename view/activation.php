<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Активация аккаунта</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <a href="/signup.php">Регистрация</a> | <a href="/password.php">Забыли пароль?</a> | <strong>Активация аккаунта</strong>
    </div>
</div>
<form method="POST">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p>
                <strong>Активировать свой аккаунт</strong> - это значит подтвердить,
                что указанный при регистрации почтовый ящик принадлежит вам и работает.<br/>
                Только после этого вы сможете полностью пользоваться функциями сайта.
            </p>
            <p>
                Для активации своего аккаунта вам нужно ввести код активации,
                который был отправлен вам по электронной почте.
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-4 hidden-xs text-right">
            <label class="strong" for="activation-code">Код активации:</label>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center">
            <label class="strong" for="activation-code">Код активации:</label>
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <input
                class="form-control"
                id="activation-code"
                name="data[code]"
                required
                type="text"
            />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 hidden-xs text-right">
            <button type="submit" class="btn margin">
                Активировать аккаунт
            </button>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center">
            <button type="submit" class="btn margin">
                Активировать аккаунт
            </button>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center">
            <a href="/activation_repeat.php" class="btn margin">
                Мне не пришло письмо
            </a>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 hidden-xs text-left">
            <a href="/activation_repeat.php" class="btn margin">
                Мне не пришло письмо
            </a>
        </div>
    </div>
</form>