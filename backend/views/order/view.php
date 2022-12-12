<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\PersonalInfo;
use app\models\Products;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

// $this->title = $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

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
    <?php 
        function getData ($model) {
            $pro = '';
            for ($i=0 ;$i < count($model->product_id) ;$i++){
                $product = Products::find()->where(["product_id" => $model->product_id[$i]])->one();
                $pro = $pro.$product['productName']. " x " .$qty = $model->quantity[$i] . "<br>";
                // return ($i+1 ." ". $product['productName']. " x $qty" ."<br> ");
            }
            return ($pro);
        }
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            '_id',
            // 'order_id',
            // 'product_id',
            [
                'label' => 'Order detail',
                'attribute' => 'product',
                'format' => ['raw'],
                'value' => getData($model),
            ],
            [
                'label' => 'Customer',
                'attribute' => 'fname',
                'format' => ['raw'],
                'value' => function ($model) {
                    $personal = PersonalInfo::find()->where(["user_id" => $model->user_id])->one();
                    return ($personal->fname. " " . $personal->lname);
                }
            ],
            'price',
            // 'quantity',
            'payment',
            'status',
            'parcelNumber'
        ],
    ]) ?>

</div>
