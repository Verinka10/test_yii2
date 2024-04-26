<?php

use app\modules\photobank\models\Photobank;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\photobank\models\PhotobankSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Photobanks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photobank-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Photobank', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'filename',
            'filename_origin',
            'content_type',
            'desription',
            //'updated_at',
            //'created_at',
            //'updated_user_id',
            //'created_user_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Photobank $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
