<?php

namespace app\controllers;

use app\models\Category;
use app\models\News;
use app\models\NewsComment;
use app\models\search\NewsCommentSearch;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Class NewsController
 * @package app\controllers
 */
class NewsController extends Controller
{
    private $allowedActions = [
        'view'
    ];

    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     * @throws HttpException
     */
    public function beforeAction($action): bool
    {
        if ((Yii::$app->user->isGuest || !Yii::$app->user->identity->isSuperadmin()) && !in_array($action->id, $this->allowedActions)) {
            throw new HttpException(403, 'У Вас нет доступа к этой странице');
        }

        return parent::beforeAction($action);
    }

    /**
     * @param string $slug
     * @return string
     * @throws HttpException
     */
    public function actionView(string $slug): string
    {
        $model = News::find()
            ->bySlug($slug)
            ->one();

        if (!$model) {
            throw new HttpException(404, 'Новость не найдена');
        }

        $commentsModelSearch = new NewsCommentSearch();
        $commentsDataProvider = $commentsModelSearch->search(['news_id' => $model->id]);

        return $this->render('view', [
            'model' => $model,
            'commentModel' => new NewsComment(),
            'commentsDataProvider' => $commentsDataProvider,
        ]);
    }

    /**
 * @param int|null $id
 * @return string|Response
 * @throws HttpException
 */
    public function actionEdit(int $id = null)
    {
        if ($id === null) {
            $model = new News();
        } else {
            $model = News::findById($id);

            if (!$model) {
                throw new HttpException(404, 'Новость не найдена');
            }
        }

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Новость сохранена');
                return $this->redirect('/');
            }

            Yii::$app->session->setFlash('error', current($model->getFirstErrors()));
        }

        $categories = Category::find()
            ->collection();

        return $this->render('edit', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws HttpException
     */
    public function actionDelete(int $id): Response
    {
        $model = News::findById($id);

        if (!$model) {
            throw new HttpException(404, 'Новость не найдена');
        }

        try {
            $model->delete();
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        Yii::$app->session->setFlash('success', 'Новость удалена');

        return $this->redirect('/');
    }
}
