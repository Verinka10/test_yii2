<?php

use app\modules\testtasks\models\Author;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\AuthorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

	<?= $this->render('../layouts/_menu') ?>
	
    <h1><?= Html::encode($this->title) ?></h1>

	<?php if (!Yii::$app->user->isGuest) : ?>
    <p>
        <?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'created_at',
            'updated_at',
            [
                'class' => ActionColumn::class,
                'template' =>  Yii::$app->user->isGuest ?  '{subscribe}' : '{view} {update} {delete}',
                'urlCreator' => function ($action, Author $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'buttons' => [
                     'subscribe' => function ($url, $model) {
                            return Html::a('Subscribe', '/testtasks/subscriber-author/create?author_id=' . $model->id, ['target' => 'blank']);
                     }
                  ],
            ],
        ],
    ]); ?>


</div>
