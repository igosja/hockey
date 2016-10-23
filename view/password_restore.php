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
                Здесь вы можете ввести <strong>новый пароль</strong> для своего аккаунта.
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-5 col-md-4 col-sm-4 hidden-xs text-right">
                    <label class="strong" for="signup-login">Пароль:</label>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center">
                    <label class="strong" for="signup-login">Пароль:</label>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                    <input
                        class="form-control <?php
                        if (isset($data['error']['password'])) {
                            print 'has-error';
                        } elseif (isset($data['success']['password'])) {
                            print 'has-success';
                        } ?>"
                        id="password-password"
                        name="data[password]"
                        type="password"
                    />
                </div>
                <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs <?php
                if (isset($data['error']['password'])) {
                    print 'error';
                } elseif (isset($data['success']['password'])) {
                    print 'success';
                } ?>">
                    <?php if (isset($data['error']['password'])) {
                        print $data['error']['password'];
                    } elseif (isset($data['success']['password'])) {
                        print $data['success']['password'];
                    } ?>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center <?php
                if (isset($data['error']['password'])) {
                    print 'error';
                } elseif (isset($data['success']['password'])) {
                    print 'success';
                } ?>">
                    <?php if (isset($data['error']['password'])) {
                        print $data['error']['password'];
                    } elseif (isset($data['success']['password'])) {
                        print $data['success']['password'];
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button type="submit" class="btn margin">
                Сменить пароль
            </button>
        </div>
    </div>
</form>