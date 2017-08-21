<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "actions".
 *
 * @property integer $id
 * @property integer $start_date
 * @property integer $end_date
 * @property integer $min_summ
 * @property integer $coupon_id
 * @property integer $is_current
 *
 * @property Coupons $coupon
 */
class Actions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'actions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_date', 'end_date', 'min_summ', 'coupon_id', 'is_current'], 'integer'],
            [['min_summ', 'coupon_id', 'is_current'], 'required'],
            [['coupon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Coupons::className(), 'targetAttribute' => ['coupon_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'min_summ' => 'Min Summ',
            'coupon_id' => 'Coupon ID',
            'is_current' => 'Is Current',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(Coupons::className(), ['id' => 'coupon_id'])->inverseOf('actions');
    }
}
