<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\testtasks\models\Author;
use yii\captcha\Captcha;

/** @var yii\web\View $this */
/** @var app\modules\testtasks\models\SubscriberAuthor $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="subscriber-author-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'author_id')->dropDownList([''=>''] + ArrayHelper::map(Author::find()->all(), 'id', 'name'), ['multiple-'=>'multiple']) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'type' => 'tel']) ?>

    <?php /* $form->field($model, 'verifyCode')->widget(Captcha::class, [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
     ]) */?>
            
      <?php if (!$model->isNewRecord) : ?>
        <?= $form->field($model, 'created_at')->textInput(['disabled' => true]) ?>
        
    	<?= $form->field($model, 'updated_at')->textInput(['disabled' => true]) ?>
	<?php endif ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
