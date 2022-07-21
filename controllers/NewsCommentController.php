<?php

namespace app\controllers;

use app\models\NewsComment;
use Yii;
use yii\web\Response;

/**
 * Class NewsCommentController
 * @package app\controllers
 */
class NewsCommentController extends Controller
{
    /**
     * @return Response
     */
    public function actionAdd(): Response
    {
        $comment = new NewsComment();

        if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
            Yii::$app->session->setFlash('success', 'Комментарий добавлен');
        } else {
            Yii::$app->session->setFlash('error', current($comment->getFirstErrors()));
        }

        return $this->redirect('/news/' . Yii::$app->request->post('slug'));
    }
}
