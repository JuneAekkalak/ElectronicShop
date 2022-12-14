<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Brand */

$this->title = $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Brands', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="brand-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', '_id' => (string) $model->_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', '_id' => (string) $model->_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            '_id',
            'brand_id',
            'brandName',
            'brandImage',
            [
                'label' => 'Image Preview',
                'attribute' => 'brandImage',
                'contentOptions' => ['class' => 'img-fluid'],
                'format' => ['image', ['width' => '80px']],
                'value' => function ($model) {
                    return ($model->brandImage);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = "";
                    if ($model->status == "1") {
                        $text = "Active";
                    } else {
                        $text = "Inactive";
                    }
                    return $model->status." (".$text.")";
                }
            ]
        ],
    ]) ?>

</div>
