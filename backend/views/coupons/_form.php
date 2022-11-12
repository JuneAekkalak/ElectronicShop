<?php

use app\models\CouponsType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Coupons */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="coupons-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'coupon_id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'discount_amount') ?>

    <?php $type_items = ArrayHelper::map(CouponsType::find()->where(['status' => '1'])->all(), 'coupons_type_id', 'title'); ?>
    <?= $form->field($model, 'discount_type')->dropDownList(
        $type_items,
        ['prompt' => 'Select Coupon Type']
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(
        ["1" => "Active", "2" => "Inactive"],
        ['prompt' => 'Select Status']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>