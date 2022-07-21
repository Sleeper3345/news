<?php

use app\models\News;
use app\models\NewsComment;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var News $model */
/** @var NewsComment $commentModel */
/** @var ActiveDataProvider $commentsDataProvider */

$this->title = $model->title;

?>

<h2><?= Html::encode($model->title) ?></h2>
<p class="gray"><?= date('d.m.Y H:i', $model->updated_at) ?></p>
<p><?= $model->text ?></p>

<br/>

<h3>Комментарии</h3>

<br/>

<?= GridView::widget([
    'dataProvider' => $commentsDataProvider,
    'summary' => '',
    'columns' => [
        [
            'attribute' => 'updated_at',
            'label' => 'Дата',
            'content' => static function (NewsComment $model) {
                return date('d.m.Y H:i', $model->updated_at);
            },
            'enableSorting' => false,
        ],
        [
            'attribute' => 'user_id',
            'content' => static function (NewsComment $model) {
                return $model->user->username;
            },
            'enableSorting' => false,
        ],
        [
            'attribute' => 'comment',
            'content' => static function (NewsComment $model) {
                return Html::encode($model->comment);
            },
            'enableSorting' => false,
        ],
    ],
]) ?>

<?php if (Yii::$app->user->isGuest): ?>
    <h4>Авторизуйтесь, чтобы оставлять комментарии под новостью</h4>
<?php else: ?>
    <h4>Написать комментарий</h4>

    <?php $form = ActiveForm::begin([
        'action' => Url::toRoute('/news-comment/add'),
        'method' => 'post',
        'enableClientValidation' => true,
    ]); ?>

    <?= Html::hiddenInput('slug', $model->slug) ?>

    <?= $form->field($commentModel, 'news_id')->hiddenInput(['value' => $model->id])->label(false) ?>

    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($commentModel, 'comment')->textarea() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

<?php endif ?>
