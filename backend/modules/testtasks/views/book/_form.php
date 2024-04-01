<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\testtasks\models\Author;

/** @var yii\web\View $this */
/** @var app\modules\testtasks\models\Book $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publish_year')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    
    <?= Html::img($model->getUrl(), ['class' => 'pull-left img-responsive', 'width' => 300]); ?>
    
    <?= Html::a("Delete image", ['delete-upload', 'id' => $model->id]); ?>
    
    <?= $form->field($model, 'cover_photo')->fileInput() ?>
    
       <?php /*$form->field($model, 'bookToAuthors')->widget(Select2::class, [
            'data'          => ArrayHelper::map(Author::find()->all(), 'id', 'name'),
            'options'       => [
                'placeholder' => 'Выберите справочники ...',
                'multiple'    => true,
                'value' => ArrayHelper::getColumn([1,2], 'id'),
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ]);
    */?>
    
    <?= $form->field($model, 'author_ids')->listBox(ArrayHelper::map(Author::find()->all(), 'id', 'name'), ['multiple'=>'multiple']) ?>
 
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
