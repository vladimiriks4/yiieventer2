<h1>регистрация</h1>
<?php

use yii\helpers\Html;
use \yii\widgets\ActiveForm;

//debug($model);

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>

<?= $form->field($model, 'name')->textInput(['autofocus' => true]); ?>

<?= $form->field($model, 'password')->textInput(['type' => 'password']); ?>

<?= $form->field($model, 'email')->textInput(); ?>

<div>
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
