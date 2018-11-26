<?php

use common\components\ErrorHelper;
use common\models\Country;
use yii\helpers\Html;

$country = Country::find()
    ->where(['country_id' => Yii::$app->request->get('id')])
    ->limit(1)
    ->one();
$file_name = 'file_name';

?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <h1>
                <?= $country->country_name; ?>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= $this->render('_country-links'); ?>
        </div>
    </div>
<?php if ('country_national' == $file_name) : ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= $this->render('_country-national-links'); ?>
        </div>
    </div>
<?php endif; ?>
    <div class="row margin-top">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
            Президент:
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?php if ($country->country_president_id) : ?>
                <?= $country->president->userLink(); ?>
            <?php else : ?>
                -
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
            Последний визит:
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?= $country->president->lastVisit(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
            Рейтинг президента:
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <span class="font-green"><?= 0 ?>%</span>
            |
            <span class="font-yellow"><?= 0 ?>%</span>
            |
            <span class="font-red"><?= 0 ?>%</span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
            Заместитель президента:
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?php if ($country->country_president_vice_id) : ?>
                <?= $country->vice->userLink(); ?>
            <?php else : ?>
                -
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
            Последний визит:
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?= $country->vice->lastVisit(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
            Фонд федерации:
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?php

            try {
                print Yii::$app->formatter->asCurrency($country->country_finance, 'USD');
            } catch (Exception $e) {
                ErrorHelper::log($e);
            }

            ?>
        </div>
    </div>
<?php if (in_array(Yii::$app->user->id, [$country->country_president_id, $country->country_president_vice_id])) : ?>
    <div class="row margin">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert info">
            <?= Html::a(
                'Создать новость',
                ['country/news-create', 'id' => Yii::$app->request->get('id')]
            ); ?>
            |
            <?= Html::a(
                'Создать опрос',
                ['country/poll-create', 'id' => Yii::$app->request->get('id')]
            ); ?>
            <?php if (Yii::$app->user->id == $country->country_president_id): ?>
                |
                <?= Html::a(
                    'Распределить фонд',
                    ['country/money-transfer', 'id' => Yii::$app->request->get('id')]
                ); ?>
            <?php endif; ?>
            <?php if ((Yii::$app->user->id == $country->country_president_id && $country->country_president_vice_id) || Yii::$app->user->id == $country->country_president_vice_id) { ?>
                |
                <?= Html::a(
                    'Отказаться от должности',
                    ['country/fire', 'id' => Yii::$app->request->get('id')]
                ); ?>
            <?php } ?>
        </div>
    </div>
<?php endif; ?>