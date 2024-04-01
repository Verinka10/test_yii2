<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\testtasks\models\SubscriberAuthor $model */

$this->title = 'Create Subscriber Author';

if (Yii::$app->user->isGuest){
    $this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['/testtasks/author/index']];
} else {
    $this->params['breadcrumbs'][] = ['label' => 'Subscriber Authors', 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscriber-author-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
