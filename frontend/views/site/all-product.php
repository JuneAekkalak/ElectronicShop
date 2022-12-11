<?php

use yii\helpers\Html;
use app\models\Products;
use app\models\Brand;
use app\models\Type;
// variables
$type = Type::find()->where(['status' => '1'])->all();
// $product = Products::find()->where(['status' => '1'])->all();
$brandName;
$typeName;
$searched = false;
$products;

// search product handler
if (isset($_GET['product_name'])) {
    $products = $this->context->actionSearchProduct($_GET['product_name']);
    $searched = true;
} else {
    $products = Products::find()->where(['status' => '1'])->all();
}
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <style media="screen">
        h4 {
            font-size: 100%;
        }
    </style>
</head>

<div class="row container-fluid">
    <div class="col-3">
        <div class="card text-bg-light">
            <div class="card-body">
                <div class="flex">
                    <div class="mb-2">
                        <label>ช่วงราคาสินค้า</label>
                        <div class="d-inline-flex align-items-center">
                            <input type="text" class="form-control" placeholder="Min">
                            <span class="mx-2">-</span>
                            <input type="text" class="form-control" placeholder="Max">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label>แบรนด์</label>
                        <?php $brand_items = Brand::find()->where(['status' => '1'])->all();
                            foreach ($brand_items as $key => $value) { ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="<?= $value->brandName ?>;" value="<?= $value->brandName ?>">
                                    <label class="form-check-label"><?= $value->brandName ?></label>
                                </div>
                            <?php }
                        ?>
                    </div>
                    <div class="mb-2">
                        <label>ประเภท</label>
                        <?php $type_items = Type::find()->where(['status' => '1'])->all();
                            foreach ($type_items as $key => $value) { ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="<?= $value->typeName ?>;" value="<?= $value->typeName ?>">
                                    <label class="form-check-label"><?= $value->typeName ?></label>
                                </div>
                            <?php }
                        ?>
                    </div>
                    <!--search button-->
                    <button class="btn btn-primary btn-block my-1">Search</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-9 container">
        <section style="margin: 0px 0">
            <div class="container">
                <div class="mb-5">
                    <label>
                        <h2>ค้นหาสินค้า 🔍</h2>
                    </label>
                    <div class="d-flex">
                        <input type="text" id="productName" class="form-control" value="<?php echo isset($_GET['product_name']) ? $_GET['product_name'] : null; ?>" placeholder="ชื่อสินค้า, ยี่ห้อ">
                        <button class="btn btn-primary ml-2" onclick="searchProduct()">Search</button>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="title" style="margin-bottom: 3em !important;">
                    <h1>All Products</h1>
                    มีสินค้าพร้อมขายทั้งหมด <?= count($products) ?> ชิ้น
                    <br>
                    <br>
                    <?= Html::a('< กลับไปหน้าหลัก', ['/site/index'], ['class' => 'h5']) ?>
                </div>
                <div class="row">
                    <?php
                    if ($searched) {
                        foreach ($products as $index => $model) { ?>
                            <div class="col-md-3 col-6" style="margin-bottom: 4em;">
                                <!-- card item -->
                                <div class="single_product_model">
                                    <div style="height: 220px;">
                                        <img src="<?= $model->productImage[1] ?>" alt="">
                                    </div>
                                    <div class="single_product_text mt-5" style="height: 220px;">
                                        <h4><?= strlen($model->productName) > 80 ? mb_substr($model->productName, 0, 80, 'UTF-8') . "..." : " " ?></h4>
                                        <?php $brandName = Brand::find()->where(['brand_id' => $model->brand_id])->one()->brandName; ?>
                                        <p><?= $brandName ?></p>
                                        <div class="d-flex justify-content-between">
                                            <b style="color: #F1574F;">
                                                ฿ <?= number_format($model->productPrice) ?>
                                            </b>
                                            <!-- price before discount -->
                                            <b style="color: #BDBDBD; text-decoration: line-through;">
                                                ฿ <?= number_format($model->productPrice + 2000) ?>
                                            </b>
                                        </div>
                                        <p><?= strlen($model->productDescrip) > 50 ? mb_substr($model->productDescrip, 0, 50, 'UTF-8') . "..." : " " ?></p>
                                    </div>
                                    <a href="index.php?r=products/view&_id=<?= $model->product_id ?>" class="btn btn-warning btn-sm btn-block mt-2">More Detail</a>
                                </div>
                                <!-- end of card item -->
                            </div>
                        <?php }
                    } else {
                        foreach ($products as $index => $model) { ?>
                            <div class="col-md-3 col-6" style="margin-bottom: 4em;">
                                <!-- card item -->
                                <div class="single_product_model">
                                    <div style="height: 220px;">
                                        <img src="<?= $model->productImage[1] ?>" alt="">
                                    </div>
                                    <div class="single_product_text mt-5" style="height: 220px;">
                                        <h4><?= $model->productName ?></h4>
                                        <?php $brandName = Brand::find()->where(['brand_id' => $model->brand_id])->one()->brandName; ?>
                                        <p><?= $brandName ?></p>
                                        <div class="d-flex justify-content-between">
                                            <b style="color: #F1574F;">
                                                ฿ <?= number_format($model->productPrice) ?>
                                            </b>
                                            <!-- price before discount -->
                                            <b style="color: #BDBDBD; text-decoration: line-through;">
                                                ฿ <?= number_format($model->productPrice + 2000) ?>
                                            </b>
                                        </div>
                                        <p><?= strlen($model->productDescrip) > 50 ? mb_substr($model->productDescrip, 0, 50, 'UTF-8') . "..." : " " ?></p>
                                    </div>
                                    <a href="index.php?r=products/view&_id=<?= $model->product_id ?>" class="btn btn-warning btn-sm btn-block mt-2">More Detail</a>
                                </div>
                                <!-- end of card item -->
                            </div>
                    <?php }
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    searchProduct = () => {
        const productName = document.getElementById('productName').value;

        // redirect with productName
        window.location.assign('index.php?r=site%2Fall-product&product_name=' + productName);
    }
</script>
