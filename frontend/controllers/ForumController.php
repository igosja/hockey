<?php

namespace frontend\controllers;

use common\models\ForumChapter;
use common\models\ForumGroup;
use common\models\ForumTheme;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class ForumController
 * @package frontend\controllers
 */
class ForumController extends AbstractController
{
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

        $this->setSeoTitle('Форум');

        return $this->render('index', [
            'forumChapterArray' => $forumChapterArray,
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

        $this->setSeoTitle('Форум');

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
            ->where(['forum_theme_forum_group_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeForum']
            ]
        ]);

        $this->setSeoTitle('Форум');

        return $this->render('group', [
            'dataProvider' => $dataProvider,
            'forumGroup' => $forumGroup,
        ]);
    }
}
