<?php

namespace app\controllers;

use app\models\search\NewsSearch;
use Yii;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @param int|null $categoryId
     * @return string
     */
    public function actionIndex(int $categoryId = null): string
    {
        $modelSearch = new NewsSearch();
        $dataProvider = $modelSearch->search(['category_id' => $categoryId]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
