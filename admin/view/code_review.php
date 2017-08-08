<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Code review</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p>Проверить:</p>
        <ul>
            <li>Общий внешний вид страницы, наличие нужных элементов, дизайн (за основу берем ВСОЛ)</li>
            <li>Корректрость html (https://validator.w3.org/)</li>
            <li>PHPDoc</li>
            <li>Explain всех sql-запросов</li>
            <li>Правильность get парметров (если передан num несущесвующей команды, нужно бросать на ошибочную страницу)</li>
            <li>Иньекции от пользователей в текстовых полях</li>
            <li>Правильные доступы к страницам (все/авторизованные/с командой/сборники/президенты)</li>
            <li>Правильные доступы к страницам голосований и похожих страниц</li>
            <li>Наличие всех проверок согласно правил</li>
            <li>Наличие нужного функционала (в т.ч. пагинация, фильтрация, сортировка, переключение между сезонами)</li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <thead>
            <tr>
                <th>Файл</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($file_array as $item) { ?>
                <tr>
                    <td><?= $item; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>