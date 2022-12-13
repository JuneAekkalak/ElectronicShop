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
if (isset($_GET['product_name']) && isset($_GET['min']) && isset($_GET['max'])) {
    $min = 0;
    $max = PHP_INT_MAX;
    $product_name = '';
    $brand = [];
    $type = [];

    if (isset($_GET['product_name']))
        if (!empty($_GET['product_name']))
            $product_name = $_GET['product_name'];
    if (isset($_GET['min']))
        if (!empty($_GET['min']))
            $min = $_GET['min'];
    if (isset($_GET['max']))
        if (!empty($_GET['max']))
            $max = $_GET['max'];
    if (isset($_GET['brand']))
        if (!empty($_GET['brand']))
            $brand = $_GET['brand'];
    if (isset($_GET['type']))
        if (!empty($_GET['type']))
            $type = $_GET['type'];

    $products = [];
    // QUERY FROM DATABASE
    if (isset($_GET['brand']) && isset($_GET['type']))
        $result = Products::find()->where(['LIKE', 'productName', $product_name, 'status' => '1'])->andWhere(['in', 'brand_id', $brand])->andWhere(['in', 'type_id', $type])->all();
    else if (isset($_GET['brand']))
        $result = Products::find()->where(['LIKE', 'productName', $product_name, 'status' => '1'])->andWhere(['in', 'brand_id', $brand])->all();
    else if (isset($_GET['type']))
        $result = Products::find()->where(['LIKE', 'productName', $product_name, 'status' => '1'])->andWhere(['in', 'type_id', $type])->all();
    else
        $result = Products::find()->where(['LIKE', 'productName', $product_name, 'status' => '1'])->all();

    // $result = Products::find()->where(['LIKE', 'productName', $product_name, 'status' => '1'])->andWhere(['in', 'brand_id', $brand])->andWhere(['in', 'type_id', $type])->all();
    foreach ($result as $key => $item) {
        if ($item->productPrice >= $min && $item->productPrice <= $max) {
            array_push($products, $item);
        }
    }
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
            font-size: 128%;
        }
    </style>
</head>

<div class="row container-fluid">
    <div class="col-md-3">
        <div class="card text-bg-light">
            <div class="card-body">
                <div class="flex">
                    <div class="mb-2">
                        <label>ช่วงราคาสินค้า</label>
                        <div class="d-inline-flex align-items-center">
                            <input type="text" id="min" class="form-control" placeholder="Min" value="<?php echo isset($_GET['min']) ? $_GET['min'] : null ?>">
                            <span class="mx-2">-</span>
                            <input type="text" id="max" class="form-control" placeholder="Max" value="<?php echo isset($_GET['max']) ? $_GET['max'] : null ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="mb-2">
                        <label>แบรนด์</label>
                        <?php $brand_items = Brand::find()->where(['status' => '1'])->all();
                        foreach ($brand_items as $key => $value) {
                            if (isset($_GET['brand']))
                                $isSelected = in_array($value->brand_id, $_GET['brand']);
                            else
                                $isSelected = false;
                        ?>
                            <div class="form-check">
                                <input class="form-check-input" name="brand[]" id="<?= $value->brandName ?>" type="checkbox" name="<?= $value->brandName ?>;" value="<?= $value->brand_id ?>" <?php echo $isSelected ? 'checked' : null ?>>
                                <label class="form-check-label" for="<?= $value->brandName ?>"><?= $value->brandName ?></label>
                            </div>
                        <?php }
                        ?>
                    </div>
                    <hr>
                    <div class="mb-2">
                        <label>ประเภท</label>
                        <?php $type_items = Type::find()->where(['status' => '1'])->all();
                        foreach ($type_items as $key => $value) {
                            if (isset($_GET['type']))
                                $isSelected = in_array($value->type_id, $_GET['type']);
                            else
                                $isSelected = false;
                        ?>
                            <div class="form-check">
                                <input class="form-check-input" name="type[]" id="<?= $value->typeName ?>" type="checkbox" name="<?= $value->typeName ?>;" value="<?= $value->type_id ?>" <?php echo $isSelected ? 'checked' : null ?>>
                                <label class="form-check-label" for="<?= $value->typeName ?>"><?= $value->typeName ?></label>
                            </div>
                        <?php }
                        ?>
                    </div>
                    <!-- search button -->
                    <button class="btn btn-primary btn-block my-1" onclick="searchProduct()">Apply</button>
                    <!-- reset sorting -->
                    <a href="index.php?r=site%2Fall-product" class="float-right">ล้างการกรองที่เลือก</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9 container">
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
                                        <img style="max-height: 220px; display: block; margin: auto;" src="<?= $model->productImage[1] ?>" alt="">
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
                    } else {
                        foreach ($products as $index => $model) { ?>
                            <div class="col-md-3 col-6" style="margin-bottom: 4em;">
                                <!-- card item -->
                                <div class="single_product_model">
                                    <div style="height: 220px;">
                                        <img style="max-height: 220px; display: block; margin: auto;" src="<?= $model->productImage[1] ?>" alt="">
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
        const min = document.getElementById('min').value;
        const max = document.getElementById('max').value;

        // check if user enter invalid value
        if (min > max || min < 0 || max < 0) {
            alert('กรุณาใส่ช่วงราคาที่ถูกต้อง');
            return;
        }

        // build query string from checkbox [brand]
        let brand = '';
        document.getElementsByName('brand[]').forEach(function(item) {
            if (item.checked) brand += ('&brand[]=' + item.value);
        })

        // build query string from checkbox [type]
        let type = '';
        document.getElementsByName('type[]').forEach(function(item) {
            if (item.checked) type += ('&type[]=' + item.value);
        })

        // redirect with productName
        window.location.assign(`index.php?r=site%2Fall-product&product_name=${productName}&min=${min}&max=${max}${brand}${type}`);
    }
</script>