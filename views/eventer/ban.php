<h1>Вход</h1>
<?php

use app\models\Event;
use yii\helpers\Html;
use \yii\widgets\ActiveForm;

$this->title = 'Ban';
$this->params['breadcrumbs'][] = $this->title;

$model = Event::find()->select('id,title')->asArray()->all();
array_unshift($model, ['id' => -1, 'title' => 'Выбрать все']);
$itemsModel = \yii\helpers\ArrayHelper::map($model, 'id', 'title');

?>
<?php $form = ActiveForm::begin(['class' => 'form-horizontal']); ?>

<?= $form->field($modelUsers, 'email')->textInput(); ?>

<?= $form->field($modelEvent, 'id[]')->dropDownList(
    $itemsModel,
    [
        'multiple'=>'true',
    ]
)->label("Выбор события")
;?>

<div>
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

