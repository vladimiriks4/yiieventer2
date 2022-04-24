<?php

use app\models\Users;
use app\models\UsersSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//debug($searchModel);

$this->title = 'Главная презентации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php foreach ($resUsers as $item): ?>
        <p><?= Html::a($item->title, [$item->action]) ?></p>
    <?php endforeach; ?>
</div>
