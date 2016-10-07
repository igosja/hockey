<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Вход в аккаунт</h1>
    </div>
</div>
<form method="POST">
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-4 hidden-xs text-right">
            <label class="strong" for="login">Логин:</label>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center">
            <label class="strong" for="login">Логин:</label>
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <input
                class="form-control <?php
                if (isset($data['error']['auth'])) {
                    print 'has-error';
                } ?>"
                id="login"
                name="data[login]"
                type="text"
            />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-4 hidden-xs text-right">
            <label class="strong" for="password">Пароль:</label>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center">
            <label class="strong" for="password">Пароль:</label>
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <input
                class="form-control <?php
                if (isset($data['error']['auth'])) {
                    print 'has-error';
                } ?>"
                id="password"
                name="data[password]"
                type="password"
            />
        </div>
        <div class="col-lg-4 col-md-3 col-sm-3 hidden-xs <?php
        if (isset($data['error']['auth'])) {
            print 'error';
        } ?>">
            <?php if (isset($data['error']['auth'])) {
                print $data['error']['auth'];
            } ?>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center <?php
        if (isset($data['error']['auth'])) {
            print 'error';
        } ?>">
            <?php if (isset($data['error']['auth'])) {
                print $data['error']['auth'];
            } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 hidden-xs text-right">
            <button type="submit" class="btn margin">
                Вход
            </button>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12 text-center">
            <button type="submit" class="btn margin">
                Вход
            </button>
        </div>
    </div>
</form>