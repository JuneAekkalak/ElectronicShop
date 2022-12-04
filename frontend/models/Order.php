<?php

namespace app\models;

use Yii;

/**
 * This is the model class for collection "order".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $order_id
 * @property mixed $product_id
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
            'order_id',
            'product_id',
            'user_id',
            'price',
            'quantity',
            'payment',
            'status',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'user_id', 'price', 'quantity', 'payment', 'status'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'payment' => 'Payment',
            'status' => 'Status',
        ];
    }
    public function getTableSchema(){
        return false;
    }
}
