<?php

use app\models\Event;
use yii\helpers\Html;
use \yii\widgets\ActiveForm;

$this->title = 'Add User';
$this->params['breadcrumbs'][] = $this->title;

?>

<p>Укажите имя, email и пароль для нового пользователя</p>

<?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>

<?= $form->field($modelUsers, 'name')->textInput(); ?>

<?= $form->field($modelUsers, 'email')->textInput(); ?>

<?= $form->field($modelUsers, 'password')->textInput(); ?>

<div>
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
