<?php

use app\modules\testtasks\models\SubscriberAuthor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SubscriberAuthorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Subscriber Authors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscriber-author-index">

	<?= $this->render('../layouts/_menu') ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('Create Subscriber Author', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'author_id',
            'phone',
            'created_at',
            'updated_at',
            //'is_active',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SubscriberAuthor $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
