<?php

use app\models\Event;
use app\models\Role;
use yii\helpers\Html;
use \yii\widgets\ActiveForm;

$this->title = 'Add User';
$this->params['breadcrumbs'][] = $this->title;

$itemsModel = [
    Role::ROLE_ADMIN => 'админ',
    Role::ROLE_ORG => 'организатор',
    Role::ROLE_USER => 'юзер',
];

?>

<p>Укажите имя, email и пароль для нового пользователя</p>

<?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>

<?= $form->field($modelUsers, 'name')->textInput(); ?>

<?= $form->field($modelUsers, 'email')->textInput(); ?>

<?= $form->field($modelUsers, 'password')->textInput(); ?>

<?= $form->field($modelUsers, 'role_id')->dropDownList(
    $itemsModel,
    [

    ]
)->label("выбор роли")
;?>

<div>
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
