<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Регистрация в игре</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Регистрация | Забыли пароль? | Активация аккаунта
    </div>
</div>
<form method="POST">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p>
                Ваша <strong>карьера тренера-менеджера</strong>
                в Виртуальной Хоккейной Лиге начинается прямо здесь и сейчас.<br/>
                Для того, чтобы мы могли отличить вас от других игроков, придумайте себе
                <strong>логин</strong> и <strong>пароль</strong>:
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-5 col-md-4 col-sm-4 hidden-xs text-right">
                    <label class="strong" for="signup-login">Логин:</label>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center">
                    <label class="strong" for="signup-login">Логин:</label>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                    <input
                        class="form-control <?php if (isset($data['error_login'])) { ?>has-error<?php } ?>"
                        id="signup-login"
                        name="data[login]"
                        required
                        type="text"
                        value="<?= $data['login']; ?>"
                    />
                </div>
                <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs error signup-login-error">
                    <?php if (isset($data['error_login'])) {
                        print $data['error_login'];
                    } ?>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center error signup-login-error">
                    <?php if (isset($data['error_login'])) {
                        print $data['error_login'];
                    } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-4 col-sm-4 hidden-xs text-right">
                    <label class="strong">Пароль:</label>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center">
                    <label class="strong">Пароль:</label>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                    <input
                        class="form-control <?php if (isset($data['error_password'])) { ?>has-error<?php } ?>"
                        id="signup-password"
                        name="data[password]"
                        required
                        type="password"
                    />
                </div>
                <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs error signup-password-error">
                    <?php if (isset($data['error_password'])) {
                        print $data['error_password'];
                    } ?>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center error signup-password-error">
                    <?php if (isset($data['error_password'])) {
                        print $data['error_password'];
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p>
                На <strong>ваш e-mail</strong> отправится код активации аккаунта.
                Потом туда можно запросить пароль, если вы его забудете:
            </p>
        </div>
    </div>
    <div class="row">
        <div class="row">
            <div class="col-lg-5 col-md-4 col-sm-4 hidden-xs text-right">
                <label class="strong" for="signup-email">Ваш email:</label>
            </div>
            <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center">
                <label class="strong" for="signup-email">Ваш email:</label>
            </div>
            <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                <input
                    class="form-control <?php if (isset($data['error_login'])) { ?>has-error<?php } ?>"
                    id="signup-email"
                    name="data[email]"
                    required
                    type="email"
                    value="<?= $data['email']; ?>"
                />
            </div>
            <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs error signup-email-error">
                <?php if (isset($data['error_email'])) {
                    print $data['error_email'];
                } ?>
            </div>
            <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center error signup-email-error">
                <?php if (isset($data['error_email'])) {
                    print $data['error_email'];
                } ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p>
                После того, как вы придумали логин, пароль и ввели свой работающий e-mail
                - <strong>нажмите</strong> на кнопку для начала игры:
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button type="submit" class="btn">
                Начать карьеру менеджера
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p>
                Начиная карьеру менеджера, вы принимаете соглашение о пользовании сайтом.
            </p>
            <p>
                Обратите внимание, у нас запрещено играть одновременно под несколькими никами.
            </p>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Вход через соцсети.
    </div>
</div>