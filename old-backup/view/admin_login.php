<div class="row">
    <div class="col-lg-4 col-md-8 col-sm-10 col-xs-12 col-lg-offset-4 col-md-offset-2 col-sm-offset-1">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Вход</h3>
            </div>
            <div class="panel-body">
                <?php if (isset($_SESSION['backend']['message'])) { ?>
                    <div class="alert alert-<?= $_SESSION['backend']['message']['class']; ?> text-center">
                        <?= $_SESSION['backend']['message']['text']; ?>
                        <?php unset($_SESSION['backend']['message']); ?>
                    </div>
                <?php } ?>
                <form method="POST">
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="Логин" name="data[login]" autofocus/>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Пароль" name="data[password]" type="password"/>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block">Вход</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>