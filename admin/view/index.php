<?php
/**
 * @var $freeteam_array array
 * @var $teamask_array array
 * @var $support_array array
 */
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Админ</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-dribbble fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $freeteam_array[0]['count']; ?></div>
                        <div>Свободные команды</div>
                    </div>
                </div>
            </div>
            <a href="/admin/team_list.php">
                <div class="panel-footer">
                    <span class="pull-left">Список команд</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <?php if ($teamask_array[0]['count']) { ?>
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= $teamask_array[0]['count']; ?></div>
                            <div>Заявки на команды!</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/teamask_list.php">
                    <div class="panel-footer">
                        <span class="pull-left">Подробнее</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
    <?php if ($support_array[0]['count']) { ?>
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= $support_array[0]['count']; ?></div>
                            <div>Новые вопросы</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/support_list.php">
                    <div class="panel-footer">
                        <span class="pull-left">Подробнее</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
</div>