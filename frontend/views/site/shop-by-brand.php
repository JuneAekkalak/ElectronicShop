<?php

use yii\helpers\Html;
use app\models\Products;
use app\models\Brand;
use app\models\Type;
// variables
$product = Products::find()->where(['status' => '1'])->where(['brand_id' => $brand_id])->all();
$brandName = Brand::find()->where(['brand_id' => $brand_id])->one()->brandName;
?>

<section style="margin: 70px 0;">
    <div class="container">
        <h1 class="h1 mt-2"><?= $brandName ?></h1>
        <div class="row">
            <?php foreach ($product as $index => $model) { ?>
                <div class="col-md-3" style="margin-bottom: 4em;">
                    <!-- card item -->
                    <div class="single_product_model">
                        <div style="height: 220px;">
                            <img src="<?= $model->productImage[1] ?>" alt="">
                        </div>
                        <div class="single_product_text mt-5" style="height: 220px;">
                            <h4><?= $model->productName ?></h4>
                            <p><?= $brandName ?></p>
                            <div class="d-flex justify-content-between">
                                <b style="color: #F1574F;">
                                    $ <?= number_format($model->productPrice) ?>
                                </b>
                                <!-- price before discount -->
                                <b style="color: #BDBDBD; text-decoration: line-through;">
                                    $ <?= number_format($model->productPrice + 2000) ?>
                                </b>
                            </div>
                            <p><?= strlen($model->productDescrip) > 50 ? mb_substr($model->productDescrip, 0, 50, 'UTF-8') . "..." : " " ?></p>
                        </div>
                        <a href="index.php?r=products/view&_id=<?= $model->product_id ?>" class="btn btn-warning btn-sm btn-block mt-2">More Detail</a>
                    </div>
                    <!-- end of card item -->
                </div>
            <?php } ?>
        </div>
    </div>
</section>