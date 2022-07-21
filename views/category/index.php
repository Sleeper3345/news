<?php

use app\models\Category;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Категории';

/** @var View $this */
/** @var ActiveDataProvider $dataProvider */

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        [
            'attribute' => 'name',
            'content' => static function (Category $model) {
                return Html::encode($model->name);
            },
            'enableSorting' => false,
        ],
        [
            'attribute' => 'parent_id',
            'content' => static function (Category $model) {
                return Html::encode($model->parent->name);
            },
            'enableSorting' => false,
        ],
        [
            'attribute' => 'updated_at',
            'label' => 'Дата',
            'content' => static function (Category $model) {
                return date('d.m.Y H:i', $model->updated_at);
            },
            'enableSorting' => false,
        ],
        [
            'class' => ActionColumn::class,
            'template' => '{update}<br />{delete}',
            'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->isSuperadmin(),
            'buttons' => [
                'update' => static function (string $url, Category $model) {
                    return Html::a('Редактировать', Url::toRoute(['edit', 'id' => $model->id]));
                },
                'delete' => static function (string $url, Category $model) {
                    return Html::a('Удалить', Url::toRoute(['delete', 'id' => $model->id]));
                },
            ],
        ]
    ],
]) ?>

<?= Html::a('Добавить категорию', ['edit'], ['class' => 'btn btn-primary']) ?>
