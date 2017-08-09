<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users_coupons".
 *
 * @property integer $user_id
 * @property integer $coupon_id
 *
 * @property Coupons $coupon
 * @property Users $user
 */
class UsersCoupons extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_coupons';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'coupon_id'], 'integer'],
            [['coupon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Coupons::className(), 'targetAttribute' => ['coupon_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'coupon_id' => 'Coupon ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(Coupons::className(), ['id' => 'coupon_id'])->inverseOf('usersCoupons');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id'])->inverseOf('usersCoupons');
    }
}
