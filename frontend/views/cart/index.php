<?php

use app\models\Products;
use app\models\Coupons;
use frontend\controllers\ProductsController;
use frontend\controllers\CartController;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Carts';
// $this->params['breadcrumbs'][] = $this->title;
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
        <?= Html::a('ไปยังหน้าชำระเงิน >', ['#'], ['class' => 'text-dark']) ?>
      </div>
    </div>
  </div>

  <!-- cart area -->
  <section class="cart_area" style="padding-bottom: 100px;">
    <div class="container">
      <h1>Cart</h1>
      <?php
      foreach ($cart as $index => $item) {
        $amount += $item->quantity;
      }
      ?>
      <p>คุณมีสินค้าทั้งหมด <?= $amount ?> ชั้น</p>
      <br>
      <div class="cart_inner">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>
                <th scope="col">Option</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($cart as $model) :
                $subtotal += (int)$model->quantity * (int)$model->price;
                $product = Products::find()->where(["product_id" => $model->product_id])->one();
                $total += (int)$model->quantity * (int)$product->productPrice;
                // var_dump($product);
              ?>
                <tr>
                  <td>
                    <div class="media">
                      <div class="d-flex " style="height: 220px;">
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
                  <td>
                    <div class="product_count">
                      <input class="input-number" type="number" style="text-align: center;" value="<?= $model->quantity ?>" disabled>
                    </div>
                  </td>
                  <td>
                    <h5><?= number_format($total) ?></h5>
                  </td>
                  <td>
                    <?= Html::a('Remove', ['delete', '_id' => (string) $model->_id], [
                      'class' => 'btn btn-danger btn-sm',
                      'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                      ],
                    ]) ?>
                  </td>
                </tr>
              <?php $total = 0;
              endforeach; ?>
              <tr class="bottom_button">
                <td>
                  <a class="btn_1" href="index.php?r=cart%2Findex">Update Cart</a>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="5" style="overflow-x: hidden;">
                  <div class="row">
                    <div class="col">
                      <input type="text" class="form-control coupon-code" placeholder="Coupon Code" />
                    </div>
                    <div class="col">
                      <button class="btn bg-success text-white btn-block text-center use-code">Use Code</button>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td colspan="2">
                  <h5>Subtotal</h5>
                  <h6>(VAT Include)</h6>
                </td>
                <td>
                  <h5 class="sub-total" style="display: none;"><?= $subtotal ?></h5>
                  <h5><?= number_format($subtotal) ?> ฿</h5>
                </td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td colspan="2">
                  <h5>Discount</h5>
                </td>
                <td>
                  <h5><span class="discount">0</span> ฿</h5>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="checkout_btn_inner float-right">
            <?= Html::a('Continue Shopping', ['/site/index'], ['class' => 'btn_1']) ?>
            <a class="btn_1 checkout_btn_1 bg-primary text-light" href="#">Proceed to checkout</a>
          </div>
        </div>
      </div>
  </section>
</section>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.use-code').click(function(e) {
      e.preventDefault();
      let code = $('.coupon-code').val();
      let subTotal = parseInt($('.sub-total').text());
      let result;

      if(code.length === 0) {
        return;
      }

      result = ((code / 100) * subTotal);

      $('.discount').text(result.toLocaleString());
    });
  });
</script>