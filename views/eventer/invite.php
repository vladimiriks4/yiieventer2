<h1>Вход</h1>
<?php

use app\models\Event;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use \yii\widgets\ActiveForm;

$this->title = 'Invite';
$this->params['breadcrumbs'][] = $this->title;



?>
<p><?= isset($alert) ? $alert : ''?></p>

<p>Укажите имя, email и мероприятие на которое вы хотели пригласить пользователя</p>

<?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>

<?= $form->field($modelUsers, 'name')->textInput(); ?>

<?= $form->field($modelUsers, 'email')->textInput(); ?>

<?= $form->field($modelEvent, 'id')->dropDownList(
        $itemsModel,
        [

        ]
    )->label("Выбор события")
;?>

<div>
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
