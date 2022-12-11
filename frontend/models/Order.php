<?php

namespace app\models;

use Yii;

/**
 * This is the model class for collection "order".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $order_id
 * @property array $product_id
 * @property mixed $user_id
 * @property mixed $price
 * @property mixed $quantity
 * @property mixed $payment
 * @property mixed $status
 */
class Order extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            // 'order_id',
            'product_id',
            'user_id',
            'price',
            'quantity',
            'payment',
            'status',
            'parcelNumber'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'price', 'quantity', 'payment', 'status','parcelNumber'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID', //use
            // 'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'price' => 'Price',//use
            'quantity' => 'Quantity',
            'payment' => 'Payment',//use
            'status' => 'Status',//use
            'parcelNumber' => 'parcelNumber',//use
        ];
    }
    public function getTableSchema(){
        return false;
    }
}
