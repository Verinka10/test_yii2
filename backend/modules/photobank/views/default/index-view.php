<?php

use app\modules\photobank\models\Photobank;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\photobank\models\PhotobankSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Photobank';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photobank-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'url:image',
             [
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(Html::img($model->thumbUrl), $model->url, ['target' => 'blank']);
                },
             ],
            'filename',
            'filename_origin',
            //'content_type',
            //'desription',
            //'updated_at',
            'created_at',
            //'updated_user_id',
            //'created_user_id',
            /*[
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Photobank $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],*/
            [
            'class' => ActionColumn::class,
            'template' => '{download}',
            'urlCreator' => function ($action, Photobank $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            },
            'buttons' => [
                    'download' => function ($url, $model) {
                        return Html::a('zip', '/photobank/default/download?model_id=' . $model->id);
                    }
                ],
            ],
        ],
    ]); ?>


</div>
