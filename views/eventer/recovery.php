<h1>Вход</h1>
<?php

use yii\helpers\Html;
use \yii\widgets\ActiveForm;

$this->title = 'Recovery';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>

<?= $form->field($model, 'email')->textInput(); ?>

<?= $form->field($model, 'password')->textInput(['type' => 'password']); ?>

<div>
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
