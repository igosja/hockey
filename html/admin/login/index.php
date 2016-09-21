<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-8 col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-2">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Вход</h3>
            </div>
            <div class="panel-body">
                <?php if (isset($_SESSION['error_auth'])) { ?>
                    <div class="alert alert-danger text-center" role="alert"><?= $_SESSION['error_auth']; ?></div>
                <?php unset($_SESSION['error_auth']); } ?>
                <form role="form" method="POST">
                    <div class="form-group">
                        <input class="form-control" placeholder="Логин" name="data[login]" type="text" autofocus>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Пароль" name="data[password]" type="password">
                    </div>
                    <button type="submit" class="btn btn-lg btn-success btn-block">Войти</button>
                </form>
            </div>
        </div>
    </div>
</div>