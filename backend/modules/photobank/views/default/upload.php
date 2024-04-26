<?php

use yii\helpers\Html;
use dosamigos\fileupload\FileUpload;
use dosamigos\fileupload\FileUploadUI;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/** @var yii\web\View $this */

$this->title = 'Upload Image';
$this->params['breadcrumbs'][] = 'Upload';
?>

<div class="photobank-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

     <?= $form->field($model, 'files[]')->fileInput(['multiple' => 'multiple']) ?>
    
     <button>Submit</button>
    
    <?php ActiveForm::end() ?>
    

</div>

