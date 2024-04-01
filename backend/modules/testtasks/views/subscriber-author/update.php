<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\testtasks\models\SubscriberAuthor $model */

$this->title = 'Update Subscriber Author: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Subscriber Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="subscriber-author-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
