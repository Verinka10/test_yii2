<?php

use app\modules\photobank\models\Photobank;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */

$this->title = 'Test api';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photobank-api">

    <h1><?= Html::encode($this->title) ?></h1>

	<?php echo Html::dropDownList('models', null, ArrayHelper::map(Photobank::find()->all(), 'id', 'filename')) ?>
	
	<?php echo Html::button('get', ['onclick' => '
        $.ajax({
            type: "POST",
            url: "",
            dataType: "json",
            data: {
                id: $("select[name=models]").val(),
            }, 
            success: function(result) {
                 $("#content").text(JSON.stringify(result, null, " "));
            },
        });
    '])
	?>
	<hr>
	<pre id="content">
	</pre>
    


</div>
