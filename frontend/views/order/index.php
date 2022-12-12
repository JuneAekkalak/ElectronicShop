<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Cart;
use frontend\controllers\CartController;
use app\models\Products;
use app\models\Order;
use app\models\PersonalInfo;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';

$order = Order::find()->where(["user_id"=>(String)Yii::$app->user->identity->id])->all();
?>
<?php $form = ActiveForm::begin(); ?>
<section style="margin: 0px 0;">
    <!-- link bar -->
  <div class="container">
    <div class="alert alert-dark w-100" role="alert" style="background-color: #F8F9FA;">
      <div class="d-flex justify-content-between">
        <?= Html::a('< กลับไปหน้าหลัก', ['/site/index'], ['class' => 'text-dark']) ?>
      </div>
    </div>
  </div>
    <section class="checkout_area  "style="padding-bottom: 10px;">
        <div class="container">
        <h1>รายการคำสั่งซื้อปัจจุบัน</h1>
        <div class="billing_details">
            <div class="row">
            <div class="col-lg-12">
            <div class="cart_inner">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">รายการ</th>
                <th scope="col">ราคารวม</th>
                <th scope="col">หมายเลขพัสดุ</th>
                <th scope="col">สถานะคำสั่งซื้อ</th>
                <th scope="col">ช่องทางชำระเงิน</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($order as $model) :
                // var_dump($product);
                // exit();
              ?>
                <tr>
                  <td>
                    <div class="media">
                      <div class="media-body">
                        <span>
                          <?php 
                          for ($i=0 ;$i < count($model->product_id) ;$i++){
                            $product = Products::find()->where(["product_id" => $model->product_id[$i]])->one();
                            $qty = $model->quantity[$i];
                            echo $i+1 ." ". $product['productName']. " x $qty" ."<br> ";
                           
                        }?></span>
                      </div>
                    </div>
                  </td>
                  <td>
                    <h5><?= number_format($model->price) ?></h5>
                  </td>
                  <td>
                    <h5><?= $model->parcelNumber ?></h5>
                  </td>
                  <td>
                    <h5><?= $model->status ?></h5>
                  </td>
                  <td>
                    <h5><?= $model->payment ?></h5>
                  </td>
                </tr>
            </tbody>
            <?php $total = 0;
              endforeach; ?>
          </table>
        </div>
      </div>
    </section>
    </section>
<!--================End Checkout Area =================-->                   
<?php ActiveForm::end(); ?>  