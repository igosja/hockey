<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">
            Перевод даты
        </h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            Сегодня: <?= $shedule_array[0]['tournamenttype_name']; ?>, <?= $shedule_array[0]['stage_name']; ?>
        </p>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a href="?num=-1" class="btn btn-default">
            На день назад
        </a>
    </li>
    <li>
        <a href="?num=1" class="btn btn-default">
            На день вперед
        </a>
    </li>
</ul>