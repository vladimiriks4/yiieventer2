<?php

use app\models\Event;
use app\models\Users;
use yii\base\DynamicModel;
use yii\helpers\Html;
use \yii\widgets\ActiveForm;

//$this->title = 'Add Org';
$this->params['breadcrumbs'][] = $title;

$ids = null;
$about = null;

$model = DynamicModel::validateData(compact('ids', 'about'), [
    [['ids', 'about'], 'string', 'max' => 128]
]);


?>

<p>Выберите пользователя для <?= $title ?></p>

<?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>

<?= $form->field($model, 'ids')->dropDownList(
    $itemsEvent,
    [

    ]
)->label("Выбор организатора для удаления из мероприятия")
;?>

<div>
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
