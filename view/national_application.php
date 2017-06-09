<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Подача заявки</h1>
    </div>
</div>
<form method="POST">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label class="strong" for="application-text">Текст программы:</label>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <textarea
                class="form-control"
                id="application-text"
                name="data[text]"
                required
                rows="5"
            ><?= isset($electionnationalapplication_array[0]['electionnationalapplication_text']) ? $electionnationalapplication_array[0]['electionnationalapplication_text'] : ''; ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right xs-text-center">
            <button type="submit" class="btn margin">
                Сохранить
            </button>
        </div>
    </div>
</form>