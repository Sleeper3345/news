<?php

namespace app\controllers;

use app\models\search\CategorySearch;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;

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
}
