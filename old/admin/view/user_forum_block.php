<?php
/**
 * @var $num_get integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $user_array[0]['user_login']; ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/user_list.php">
            Список
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/user_view.php?num=<?= $num_get; ?>">
            Просмотр
        </a>
    </li>
</ul>
<form class="form-horizontal" method="POST">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label" for="time">Срок</label>
                    </td>
                    <td>
                        <select class="form-control" id="time" name="data[time]">
                            <option value="1">1 день</option>
                            <option value="2">2 дня</option>
                            <option value="3">3 дня</option>
                            <option value="7">7 дней</option>
                            <option value="30">30 дней</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button class="btn btn-default">Сохранить</button>
        </div>
    </div>
</form>