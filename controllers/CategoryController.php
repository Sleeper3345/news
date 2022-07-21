<?php

namespace app\controllers;

use app\models\Category;
use app\models\search\CategorySearch;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Class CategoryController
 * @package app\controllers
 */
class CategoryController extends Controller
{
    /**
     * @param $action
     * @return bool
     * @throws HttpException
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        if (Yii::$app->user->isGuest || !Yii::$app->user->identity->isSuperadmin()) {
            throw new HttpException(403, 'У Вас нет доступа к этой странице');
        }

        return parent::beforeAction($action);
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $modelSearch = new CategorySearch();
        $dataProvider = $modelSearch->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
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
            $model = new Category();
        } else {
            $model = Category::findById($id);

            if (!$model) {
                throw new HttpException(404, 'Категория не найдена');
            }
        }

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Категория сохранена');
                return $this->redirect('/category/index');
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
        $model = Category::findById($id);

        if (!$model) {
            throw new HttpException(404, 'Категория не найдена');
        }

        try {
            $model->delete();
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        Yii::$app->session->setFlash('success', 'Категория удалена');

        return $this->redirect('/category/index');
    }
}
