<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Активация аккаунта</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/register_link.php'); ?>
    </div>
</div>
<form method="POST">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p>
                Эта страничка предназначена для новых менеджеров,
                которые <strong>не смогли получить письмо с кодом активации</strong>.
            </p>
            <p>
                Для повторной оправки кода активанции введите свой <strong>email</strong>:
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label class="strong" for="activation-email">Email:</label>
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <input
                class="form-control"
                id="activation-email"
                name="data[email]"
                required
                type="email"
            />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right xs-text-center">
            <button type="submit" class="btn margin">
                Получить код
            </button>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left xs-text-center">
            <a href="/activation.php" class="btn margin">
                У меня уже есть код активации
            </a>
        </div>
    </div>
</form>