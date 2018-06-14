<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/user_profile_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                Изменение пароля
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
                <th>Изменить пароль менеджера</th>
            </tr>
        </table>
    </div>
</div>
<form method="POST" id="password-form">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            Здесь вы можете <span class="strong">изменить свой пароль менеджера</span>. Следите внимательно за регистром и кодировкой букв.
            <br/>
            Если вы забудете или потеряете пароль, то для его восстановления вам нужно будет иметь доступ к своему почтовому ящику.
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label for="password-old">Старый пароль:</label>
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <input
                class="form-control"
                id="password-old"
                name="data[password_old]"
                type="password"
            />
        </div>
        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12 xs-text-center password-old-error notification-error"></div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label for="password-new">Новый пароль</label>:
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <input
                class="form-control form-small"
                id="password-new"
                name="data[password_new]"
                type="password"
            />
        </div>
        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12 xs-text-center password-new-error notification-error"></div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label for="password-confirm">Повторите новый пароль</label>:
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <input
                class="form-control form-small"
                id="password-confirm"
                name="data[password_confirm]"
                type="password"
            />
        </div>
        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12 xs-text-center password-confirm-error notification-error"></div>
    </div>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-justify">
            Помните, что пароль <span class="strong">должен быть достаточно сложным</span>, чтобы никто не смог его угадать и использовать для управления вашими командами.
            С другой стороны, вы сами должны его хорошо помнить.
            Не рекомендуется использовать в Лиге пароли, которые подходят к вашим почтовым ящикам, форумам, используются для входа в ваш компьютер или для получения доступа к ценной информации.
            <br/>
            Пожалуйста, не указывайте в качестве пароля свой день рождения, телефон, email и другие общедоступные данные.
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button type="submit" class="btn">
                Изменить пароль
            </button>
        </div>
    </div>
</form>