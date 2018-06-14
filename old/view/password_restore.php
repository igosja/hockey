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
<form id="password-restore-form" method="POST">
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
                <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
                    <label class="strong" for="password-restore">Пароль:</label>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                    <input
                        class="form-control"
                        id="password-restore"
                        name="data[password]"
                        type="password"
                    />
                </div>
                <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12 xs-text-center password-restore-error notification-error"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button class="btn margin">
                Сменить пароль
            </button>
        </div>
    </div>
</form>