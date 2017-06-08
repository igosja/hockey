<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h1>Выборы президента</h1>
            </div>
        </div>
        <form method="POST">
            <?php foreach ($applicationpresident_array as $item) { ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input
                            id="vote-<?= $item['applicationpresident_id']; ?>"
                            name="data[vote]"
                            type="radio"
                            value="<?= $item['applicationpresident_id']; ?>"
                        />
                        <label for="vote-<?= $item['applicationpresident_id']; ?>">
                            <?= nl2br($item['applicationpresident_text']); ?>
                        </label>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <input class="btn margin" type="submit" value="Голосовать" />
                </div>
            </div>
        </form>
    </div>
</div>