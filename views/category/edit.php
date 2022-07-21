<?php

use app\models\News;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var News $model */
/** @var array $categories */

$this->title = $model->isNewRecord ? 'Добавление категории' : 'Редактирование категории';

?>

<h2><?= $this->title ?></h2>

<?php $form = ActiveForm::begin([
    'action' => Url::toRoute(['/category/edit', 'id' => $model->id]),
    'method' => 'post',
    'enableClientValidation' => true,
]); ?>

<div class="row">
    <div class="col-lg-12">
        <?= $form->field($model, 'name')->textInput() ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <?= $form->field($model, 'parent_id')->dropDownList($categories, [
            'prompt' => '-',
            'class' => 'form-control'
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
