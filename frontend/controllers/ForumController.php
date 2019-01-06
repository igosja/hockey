<?php

namespace frontend\controllers;

use common\models\ForumChapter;
use common\models\ForumGroup;
use common\models\ForumMessage;
use common\models\ForumTheme;
use frontend\models\ForumThemeForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Class ForumController
 * @package frontend\controllers
 */
class ForumController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['theme-create'],
                'rules' => [
                    [
                        'actions' => ['theme-create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $forumChapterArray = ForumChapter::find()
            ->with([
                'forumGroup',
                'forumGroup.forumMessage',
                'forumGroup.forumTheme',
                'forumGroup.forumTheme.forumMessage',
            ])
            ->orderBy(['forum_chapter_order' => SORT_ASC])
            ->all();

        $myCountyArray = [];
        foreach ($this->myTeamArray as $team) {
            $myCountyArray[] = $team->stadium->city->country->country_id;
        }

        $this->setSeoTitle('Форум');

        return $this->render('index', [
            'forumChapterArray' => $forumChapterArray,
            'myCountyArray' => $myCountyArray,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionChapter(int $id): string
    {
        $forumChapter = ForumChapter::find()
            ->with([
                'forumGroup',
                'forumGroup.forumMessage',
                'forumGroup.forumTheme',
                'forumGroup.forumTheme.forumMessage',
            ])
            ->where(['forum_chapter_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($forumChapter);

        $this->setSeoTitle($forumChapter->forum_chapter_name . ' - Форум');

        return $this->render('chapter', [
            'forumChapter' => $forumChapter,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionGroup(int $id): string
    {
        $forumGroup = ForumGroup::find()
            ->where(['forum_group_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($forumGroup);

        $query = ForumTheme::find()
            ->select(['forum_theme.*', 'forum_message_date' => 'MAX(`forum_message_date`)'])
            ->joinWith(['forumMessage'])
            ->where(['forum_theme_forum_group_id' => $id])
            ->groupBy(['forum_theme_id'])
            ->orderBy(['forum_message_date' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeForum']
            ]
        ]);

        $this->setSeoTitle($forumGroup->forum_group_name . ' - Форум');

        return $this->render('group', [
            'dataProvider' => $dataProvider,
            'forumGroup' => $forumGroup,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionTheme(int $id)
    {
        $forumTheme = ForumTheme::find()
            ->where(['forum_theme_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($forumTheme);

        $model = new ForumMessage();
        if ($model->addMessage()) {
            $this->setSuccessFlash('Сообщение успешно сохранёно');
            return $this->refresh();
        }

        $query = ForumMessage::find()
            ->where(['forum_message_forum_theme_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeForum']
            ]
        ]);

        if (!Yii::$app->request->get('page')) {
            $lastPage = ceil($query->count() / Yii::$app->params['pageSizeForum']);
            Yii::$app->request->setQueryParams(
                ArrayHelper::merge(Yii::$app->request->queryParams, ['page' => $lastPage])
            );
        }

        $forumTheme->forum_theme_count_view++;
        $forumTheme->save();

        $this->setSeoTitle($forumTheme->forum_theme_name . ' - Форум');

        return $this->render('theme', [
            'dataProvider' => $dataProvider,
            'forumTheme' => $forumTheme,
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionSearch(): string
    {
        $query = ForumMessage::find()
            ->filterWhere(['like', 'forum_message_text', Yii::$app->request->get('q')]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeForum']
            ]
        ]);

        $this->setSeoTitle('Результаты поиска - Форум');

        return $this->render('search', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionThemeCreate($id)
    {
        $forumGroup = ForumGroup::find()
            ->where(['forum_group_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($forumGroup);

        $model = new ForumThemeForm();
        if ($model->create($id)) {
            $this->setSuccessFlash('Тема успешно создана');
            return $this->redirect(['forum/theme', 'id' => $model->getThemeId()]);
        }

        $this->setSeoTitle('Создание темы - ' . $forumGroup->forum_group_name . ' - Форум');

        return $this->render('theme-create', [
            'forumGroup' => $forumGroup,
            'model' => $model,
        ]);
    }
}
