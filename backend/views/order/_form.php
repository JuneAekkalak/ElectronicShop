<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'price')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'payment')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'status')->dropDownList(
        ["กำลังตรวจสอบ" => "กำลังตรวจสอบ", "รอชำระเงิน" => "รอชำระเงิน", 
        "อยู่ระหว่างจัดส่ง" => "อยู่ระหว่างจัดส่ง", "จัดส่งสำเร็จ" => "จัดส่งสำเร็จ"],
        ['prompt' => 'Select Status']
    ) ?>

    <?= $form->field($model, 'parcelNumber') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
