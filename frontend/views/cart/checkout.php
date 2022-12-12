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
$this->title = (String)Yii::$app->user->identity->id;


$cart = Cart::find()->where(["user_id"=>(String)Yii::$app->user->identity->id])->all();
$personal = PersonalInfo::find()->where(["user_id" => (string)Yii::$app->user->identity->id])->one();
$total = 0;
$subtotal = 0;
$amount = 0;
$vat = 0;
$coupon_discount = 0;
if(isset($_GET['discount']) && !empty($_GET['discount'])) {
  $discount = $_GET['discount'];
  if($discount) {
    $coupon_discount = $discount;
  } else {
    $coupon_discount = 0;
  }
  // var_dump($discount);
  // exit();
}
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
              <?php foreach ($cart as $modelcart) :
                // $subtotal += (int)$model->quantity * (int)$model->price;
                $product = Products::find()->where(["product_id" => $modelcart->product_id])->one();
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
                    <h5><?= number_format($modelcart->price) ?></h5>
                  </td>
                  <!-- <td>
                    <div class="product_count">
                      <input class="input-number" type="number" style="text-align: center;" value="<?= $modelcart->quantity ?>" disabled>
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
                    <?php foreach ($cart as $modelcart) :
                        $subtotal += (int)$modelcart->quantity * (int)$modelcart->price;
                        $product = Products::find()->where(["product_id" => $modelcart->product_id])->one();
                        $productId = $product['product_id']; 
                        $quantity = $modelcart->quantity; 
                        $total += (int)$modelcart->quantity * (int)$product->productPrice;
                        $totalall = (($subtotal - $coupon_discount));
                        
                        echo $form->field($orderModel, 'product_id[]')->hiddenInput(['value' => $productId])->label(false);
                        echo $form->field($orderModel, 'quantity[]')->hiddenInput(['value' =>  $quantity])->label(false);
                    ?>
                    <li>
                        <a href=""><?= $product->productName ?>
                            <span class="middle">x<?= $modelcart->quantity ?></span>
                            <span class="last">฿<?=number_format($total) ?></span>
                        </a>
                    </li>
                    <?php $total = 0;
                    endforeach; ?>
                </ul>

                <ul class="list list_2">
                    <li>
                    <a href="#">รวม
                        <span>฿<?= number_format($subtotal) ?></span>
                    </a>
                    </li>
                    <li>
                    <a href="#">ส่วนลด
                        <span>฿<?= number_format($coupon_discount)?></span>
                    </a>
                    </li>
                    <li>
                    <a href="#">VAT 7 %
                        <span>฿<?= number_format($totalall * 0.07)?></span>
                    </a>
                    </li>
                    <li>
                    <a href="#">รวมทั้งหมด
                        <span>฿<?= 
                        number_format($totalall += $totalall * 0.07);
                        
                        ?></span>
                    </a>
                    </li>
                </ul>
                <div class="payment_item">
                  <div class="mt-2">
                    <?php echo $form->field($orderModel, 'payment')->radioList(
                      ['โอนเงิน'=>'โอนเงิน',
                       'เก็บเงินปลายทาง'=>'เก็บเงินปลายทาง'
                    ])->label("ช่องทางชำระเงิน");
                    ?>
                  </div> 
                </div> 
                <?php echo Html::submitButton('สั่งซื้อสินค้า', ['class' => 'btn_3 w-100 text-center']);?>
                
                <?php 
                  echo $form->field($orderModel, 'user_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false);
                  echo $form->field($orderModel, 'price')->hiddenInput(['value' => $totalall])->label(false);
                  // echo $form->field($orderModel, 'product_id')->hiddenInput(['value' => $])->label(false);
                  echo $form->field($orderModel, 'status')->hiddenInput(['value' => "กำลังตรวจสอบ"])->label(false);
                  echo $form->field($orderModel, 'parcelNumber')->hiddenInput(['value' => "N/A"])->label(false);
                ?>

                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
    <section class="checkout_area  "style="padding-bottom: 100px; margin-top:0px"> 
    <div class="container">
      <div class="col-lg-12">
      <div class="order_box">
        <h2>ที่อยู่จัดส่ง</h2>       
        <span><?= $personal->address[0] ?></span>
        <span><?= $personal->address[1] ?></span>
        <span><?= $personal->address[2] ?></span> 
        <span><?= $personal->address[3] ?></span>                   
      </div>
      </div>
      </div>
    </section>
    </section>
    <!--================End Checkout Area =================-->                   
    <?php ActiveForm::end(); ?>  