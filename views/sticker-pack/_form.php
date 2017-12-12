<?php

use yii\bootstrap\Button;
use yii\widgets\ActiveForm;
//use devgroup\dropzone\DropZone;

/* @var $this yii\web\View */
/* @var $model app\models\StickerPack */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="sticker-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'price')->dropDownList([
                '0' => 'Free',
                '0.99' => '0.99 $'
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'description')->textarea(['rows' => '2']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'gallery[]')->widget(\kartik\file\FileInput::className(), [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => 'true',
                ],
            ]);?>
        </div>
    </div>



    <?= Button::widget(["label" => "Save", "options" => ["class" => "btn-primary grid-button"]]); ?>

    <?php ActiveForm::end() ?>

</div>
