<?php

use app\models\Event;
use app\models\Users;
use yii\helpers\Html;
use \yii\widgets\ActiveForm;

//$this->title = 'Add Org';
$this->params['breadcrumbs'][] = $title;

?>

<p>Выберите пользователя для <?= $title ?></p>

<?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>

<?= $form->field($modelUsers, 'id')->dropDownList(
    $itemsUsers,
    [

    ]
)->label("Выбор пользователя")
;?>

<?= $form->field($modelEvent, 'id')->dropDownList(
    $itemsEvent,
    [

    ]
)->label("Выбор мероприятия")
;?>

<div>
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
