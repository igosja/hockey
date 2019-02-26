<?php

use common\components\FormatHelper;
use common\models\Attitude;
use common\models\Country;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$country = Country::find()
    ->where(['country_id' => Yii::$app->request->get('id')])
    ->limit(1)
    ->one();
$file_name = 'file_name';

$attitudeArray = Attitude::find()
    ->orderBy(['attitude_order' => SORT_ASC])
    ->all();
$attitudeArray = ArrayHelper::map($attitudeArray, 'attitude_id', 'attitude_name');

/**
 * @var \frontend\controllers\AbstractController $controller
 */
$controller = Yii::$app->controller;

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
        <div class="col-lg-3 col-md-4 col-sm-3 col-xs-4 text-center team-logo-div">
            <?php if (file_exists(Yii::getAlias('@webroot') . '/img/country/125/' . $country->country_id . '.png')) : ?>
                <?= Html::img(
                    '/img/country/125/' . $country->country_id . '.png?v=' . filemtime(Yii::getAlias('@webroot') . '/img/country/125/' . $country->country_id . '.png'),
                    [
                        'alt' => $country->country_name,
                        'class' => 'team-logo',
                        'title' => $country->country_name,
                    ]
                ); ?>
            <?php endif; ?>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-9 col-xs-8">
            <div class="row">
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
                    <span class="font-green"><?= $country->attitudePresidentPositive() ?>%</span>
                    |
                    <span class="font-yellow"><?= $country->attitudePresidentNeutral() ?>%</span>
                    |
                    <span class="font-red"><?= $country->attitudePresidentNegative() ?>%</span>
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
                    <?= FormatHelper::asCurrency($country->country_finance); ?>
                </div>
            </div>
        </div>
    </div>
<?php if ($controller->myTeam && $controller->myTeam->stadium->city->country->country_id == $country->country_id) : ?>
    <?php $form = ActiveForm::begin([
        'action' => ['country/attitude-president', 'id' => $country->country_id],
        'fieldConfig' => [
            'labelOptions' => ['class' => 'strong'],
            'options' => ['class' => 'row text-left'],
            'template' => '<div class="col-lg-3 col-md-3 col-sm-2"></div>{input}',
        ],
    ]); ?>
    <div class="row text-center">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 relation-head">
            Ваше отношение к президенту федерации:
            <a href="javascript:" id="relation-link"><?= $controller->myTeam->attitudePresident->attitude_name; ?></a>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 relation-body hidden">
            <?= $form
                ->field($controller->myTeam, 'team_attitude_president')
                ->radioList($attitudeArray, [
                    'item' => function ($index, $model, $name, $checked, $value) {
                        $result = '<div class="hidden-lg hidden-md hidden-sm col-xs-3"></div><div class="col-lg-2 col-md-2 col-sm-3 col-xs-9">'
                            . Html::radio($name, $checked, [
                                'index' => $index,
                                'label' => $model,
                                'value' => $value,
                            ])
                            . '</div>';
                        return $result;
                    }
                ])
                ->label(false); ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?= Html::submitButton('Изменить отношение', ['class' => 'btn margin']); ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
<?php endif; ?>
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
            <?php if (false) : ?>
                <?php if (Yii::$app->user->id == $country->country_president_id): ?>
                    |
                    <?= Html::a(
                        'Распределить фонд',
                        ['country/money-transfer', 'id' => Yii::$app->request->get('id')]
                    ); ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ((Yii::$app->user->id == $country->country_president_id && $country->country_president_vice_id) || Yii::$app->user->id == $country->country_president_vice_id) : ?>
                |
                <?= Html::a(
                    'Отказаться от должности',
                    ['country/fire', 'id' => Yii::$app->request->get('id')]
                ); ?>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>