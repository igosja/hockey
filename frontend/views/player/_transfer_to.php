<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            Здесь вы можете <span class="strong">поставить своего игрока на трансферный рынок</span>.
        </p>
        <p>
            Начальная трансферная цена игрока должна быть не меньше
            <span class="strong"><?= 123; ?></span>.
        </p>
        <form method="POST">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                    <label for="price">Начальная цена, $:</label>
                </div>
                <div class="col-lg-1 col-md-2 col-sm-2 col-xs-6">
                    <input class="form-control" name="data[price]" id="price" type="text" value="<?= 123; ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="checkbox" name="data[to_league]" value="1" id="to-league"/>
                    <label for="to-league">Продать Лиге</label>
                </div>
            </div>
            <p class="text-center">
                <button class="btn" type="submit">Выставить на трансфер</button>
            </p>
        </form>
    </div>
</div>