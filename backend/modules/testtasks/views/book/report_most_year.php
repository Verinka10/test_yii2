<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Books report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

	<?= $this->render('../layouts/_menu') ?>
	
    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'publish_year',
            'count_book',
        ]
    ]);
    ?>


</div>
