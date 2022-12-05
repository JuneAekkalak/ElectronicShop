<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Cart;
use frontend\controllers\CartController;
use app\models\Products;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';

$cart = Cart::find()->where(["user_id"=>(String)Yii::$app->user->identity->id])->all();
$total = 0;
$subtotal = 0;
$amount = 0;
$vat = 0;
?>
<section style="margin: 0px 0;">
    <!-- link bar -->
  <div class="container">
    <div class="alert alert-dark w-100" role="alert" style="background-color: #F8F9FA;">
      <div class="d-flex justify-content-between">
        <?= Html::a('< กลับไปหน้าหลัก', ['/site/index'], ['class' => 'text-dark']) ?>
      </div>
    </div>
  </div>
    <section class="checkout_area  "style="padding-bottom: 100px;">
        <div class="container">
        <h1>Orders Details</h1>
        <div class="billing_details">
            <div class="row">
            <div class="col-lg-8">
            <div class="cart_inner">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
                <!-- <th scope="col">Quantity</th> -->
                <!-- <th scope="col">Total</th> -->
                <!-- <th scope="col">Option</th> -->
              </tr>
            </thead>
            <tbody>
              <?php foreach ($cart as $model) :
                // $subtotal += (int)$model->quantity * (int)$model->price;
                $product = Products::find()->where(["product_id" => $model->product_id])->one();
                // $total += (int)$model->quantity * (int)$product->productPrice;
                // var_dump($product);
              ?>
                <tr>
                  <td>
                    <div class="media">
                      <div class="d-flex " style="height: 90px; width: 130px;">
                        <img src="<?= $product->productImage[0] ?>" alt="" />
                      </div>
                      <div class="media-body">
                        <p>
                          <?= $product->productName ?></p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <h5><?= number_format($model->price) ?></h5>
                  </td>
                  <!-- <td>
                    <div class="product_count">
                      <input class="input-number" type="number" style="text-align: center;" value="<?= $model->quantity ?>" disabled>
                    </div>
                  </td> -->
                  <!-- <td>
                    <h5><?= number_format($total) ?></h5>
                  </td> -->
                </tr>
            </tbody>
            <?php $total = 0;
              endforeach; ?>
          </table>
        </div>
      </div>
        </div>
            <div class="col-lg-4">
                <div class="order_box">
                <h2>รายการสินค้าของคุณ</h2>
                <ul class="list">
                    <li>
                    <a href="">สินค้า
                        <span>รวม</span>
                    </a>
                    </li>
                    <?php foreach ($cart as $model) :
                        $subtotal += (int)$model->quantity * (int)$model->price;
                        $product = Products::find()->where(["product_id" => $model->product_id])->one();
                        $total += (int)$model->quantity * (int)$product->productPrice;
                        // var_dump($product);
                    ?>
                    <li>
                        <a href=""><?= $product->productName ?>
                            <span class="middle">x<?= $model->quantity ?></span>
                            <span class="last">$<?=number_format($total) ?></span>
                        </a>
                    </li>
                    <?php $total = 0;
                    endforeach; ?>
                </ul>

                <ul class="list list_2">
                    <li>
                    <a href="#">รวม
                        <span>$<?= number_format($subtotal) ?></span>
                    </a>
                    </li>
                    <li>
                    <a href="#">VAT 7 %
                        <span><?= number_format($subtotal * 0.07)?></span>
                    </a>
                    </li>
                    <li>
                    <a href="#">รวมทั้งหมด
                        <span>$<?= number_format($subtotal + ($subtotal * 0.07) )?></span>
                    </a>
                    </li>
                </ul>
                <div class="payment_item">
                    <div class="radion_btn">
                    <input type="radio" id="f-option5" name="selector" />
                    <label for="f-option5">เก็บเงินปลายทาง</label>
                    <div class="check"></div>
                    </div>
                </div>
                <div class="payment_item active">
                    <div class="radion_btn">
                    <input type="radio" id="f-option6" name="selector" />
                    <label for="f-option6">โอนเงิน </label>
                    <img src="img/product/single-product/card.jpg" alt="" />
                    <div class="check"></div>
                    </div>
                </div>
                <a class="btn_3" href="#">Proceed to Paypal</a>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
    </section>
    <!--================End Checkout Area =================-->

