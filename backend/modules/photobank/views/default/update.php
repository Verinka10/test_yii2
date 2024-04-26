<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Photobank $model */

$this->title = 'Update Photobank:  . $model->id';
$this->params['breadcrumbs'][] = ['label' => 'Photobanks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="photobank-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
