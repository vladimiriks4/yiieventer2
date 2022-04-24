<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Получить персональные данные';
$this->params['breadcrumbs'][] = $this->title;

//получаем все права
$permission = $user->role->permission;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <p>
        <?= Html::encode($user->name) ?>
    </p>

    <p>
        <?= Html::encode($user->email) ?>
    </p>
    <p>
        <p>Ваши права на совершение действий:</p>
        <?php foreach ($permission as $item) :?>
                <p><?= Html::a($item->title, [$item->action]) // экшн переделать в таблице, сейчас неправильный ?></p>
        <?php endforeach; ?>
    </p>


    <code><?= __FILE__ ?></code>
</div>
