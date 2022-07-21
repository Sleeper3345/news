<?php

use app\models\News;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var News $model */
/** @var array $categories */

$this->title = $model->isNewRecord ? 'Добавление новости' : 'Редактирование новости';

?>

<h2><?= $this->title ?></h2>

<?php $form = ActiveForm::begin([
    'action' => Url::toRoute(['/news/edit', 'id' => $model->id]),
    'method' => 'post',
    'enableClientValidation' => true,
]); ?>

<div class="row">
    <div class="col-lg-12">
        <?= $form->field($model, 'title')->textInput() ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <?= $form->field($model, 'category_id')->dropDownList($categories, ['class' => 'form-control']) ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <?= $form->field($model, 'announcement')->textInput() ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <?= $form->field($model, 'text')->textarea() ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
