<?php

use app\models\Products;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\widgets\Alert;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Products', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= Alert::widget()?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class'=> 'table table-striped'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // '_id',
            'product_id',
            'productName',
            'productPrice',
            [
                'attribute' => 'productImage',
                'headerOptions' => ['class' => 'img-fluid text-center'],
                'contentOptions' => ['class' => 'img-fluid text-center'],
                'format' => ['image', ['width'=>'100px']],
                'value' => function($model) {
                    return ($model->productImage[0]);
                }
            ],
            // 'productImage',
            //'productDescrip',
            //'inStock',
            //'status',
            //'type_id',
            //'brand_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, '_id' => (string) $model->_id]);
                 }
            ],
        ],
    ]); ?>


</div>
