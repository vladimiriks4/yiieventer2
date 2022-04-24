<?php

use app\models\Event;
use app\models\Users;
use yii\helpers\Html;
use \yii\widgets\ActiveForm;

$this->title = 'Delete User';
$this->params['breadcrumbs'][] = $this->title;

$model = Users::find()
    ->select('id,email')
    ->asArray()->all();
$itemsModel = \yii\helpers\ArrayHelper::map($model, 'id', 'email');

?>

<p>Выберите пользователя для удаления</p>

<?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>

<?= $form->field($modelUsers, 'id')->dropDownList(
    $itemsModel,
    [

    ]
)->label("Выбор пользователя")
;?>

<div>
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
