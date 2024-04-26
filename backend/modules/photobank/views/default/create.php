<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Photobank $model */

$this->title = 'Create Photobank';
$this->params['breadcrumbs'][] = ['label' => 'Photobanks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photobank-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
