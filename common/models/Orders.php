<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $product_price
 * @property integer $product_discount
 * @property integer $product_discount_type
 * @property integer $product_multiplier
 * @property string $addit_products
 * @property integer $coupon_id
 * @property string $coupon_name
 * @property integer $coupon_discount
 * @property integer $coupon_type
 * @property string $addressee_name
 * @property string $addressee_address
 * @property integer $addressee_apartments
 * @property integer $addressee_phone
 * @property integer $date
 * @property integer $time
 * @property integer $client_id
 * @property string $client_name
 * @property integer $client_phone
 * @property string $client_email
 * @property integer $is_anonymous
 * @property integer $has_card
 * @property integer $card_reason
 * @property string $comment
 * @property integer $total_price
 * @property integer $payment_type
 * @property integer $status
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'product_price', 'product_discount', 'product_discount_type', 'product_multiplier', 'coupon_id', 'coupon_discount', 'coupon_type', 'addressee_apartments', 'addressee_phone', 'date', 'time', 'client_id', 'client_phone', 'is_anonymous', 'has_card', 'card_reason', 'total_price', 'payment_type', 'status'], 'integer'],
            [['addressee_name', 'addressee_address', 'addressee_apartments', 'addressee_phone', 'date', 'time', 'client_id', 'client_name', 'client_phone', 'is_anonymous', 'has_card', 'total_price', 'payment_type', 'status'], 'required'],
            [['addit_products', 'coupon_name', 'addressee_name', 'addressee_address', 'client_name', 'client_email', 'comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'product_price' => 'Product Price',
            'product_discount' => 'Product Discount',
            'product_discount_type' => 'Product Discount Type',
            'product_multiplier' => 'Product Multiplier',
            'addit_products' => 'Addit Products',
            'coupon_id' => 'Coupon ID',
            'coupon_name' => 'Coupon Name',
            'coupon_discount' => 'Coupon Discount',
            'coupon_type' => 'Coupon Type',
            'addressee_name' => 'Addressee Name',
            'addressee_address' => 'Addressee Address',
            'addressee_apartments' => 'Addressee Apartments',
            'addressee_phone' => 'Addressee Phone',
            'date' => 'Date',
            'time' => 'Time',
            'client_id' => 'Client ID',
            'client_name' => 'Client Name',
            'client_phone' => 'Client Phone',
            'client_email' => 'Client Email',
            'is_anonymous' => 'Is Anonymous',
            'has_card' => 'Has Card',
            'card_reason' => 'Card Reason',
            'comment' => 'Comment',
            'total_price' => 'Total Price',
            'payment_type' => 'Payment Type',
            'status' => 'Status',
        ];
    }
}
