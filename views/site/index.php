<?php

use app\models\News;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Новости';

/** @var View $this */
/** @var ActiveDataProvider $dataProvider */

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        [
            'attribute' => 'title',
            'content' => static function (News $model) {
                return Html::a(Html::encode($model->title), Url::toRoute(['/news/' . $model->slug]), ['target' => '_blank']);
            },
            'enableSorting' => false,
        ],
        [
            'attribute' => 'text',
            'label' => 'Краткий текст',
            'content' => static function (News $model) {
                return mb_strimwidth($model->text, 0, 100, "...");
            },
            'enableSorting' => false,
        ],
        [
            'attribute' => 'updated_at',
            'label' => 'Дата',
            'content' => static function (News $model) {
                return date('d.m.Y H:i', $model->updated_at);
            },
            'enableSorting' => true,
        ],
        [
            'class' => ActionColumn::class,
            'template' => '{update}<br />{delete}',
            'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->isSuperadmin(),
            'buttons' => [
                'update' => static function (string $url, News $model) {
                    return Html::a('Редактировать', Url::toRoute(['/news/edit', 'id' => $model->id]));
                },
                'delete' => static function (string $url, News $model) {
                    return Html::a('Удалить', Url::toRoute(['/news/delete', 'id' => $model->id]));
                },
            ],
        ]
    ],
]) ?>

<?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isSuperadmin()): ?>
    <?= Html::a('Добавить новость', ['news/edit'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Список категорий', ['/category/index'], ['class' => 'btn btn-primary']) ?>
<?php endif ?>
