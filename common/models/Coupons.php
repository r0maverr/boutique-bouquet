<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "coupons".
 *
 * @property integer $id
 * @property string $name
 * @property integer $value
 * @property integer $type
 * @property integer $end_time
 *
 * @property UsersCoupons[] $usersCoupons
 */
class Coupons extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupons';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value', 'type', 'end_time'], 'required'],
            [['value', 'type', 'end_time'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'type' => 'Type',
            'end_time' => 'End Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersCoupons()
    {
        return $this->hasMany(UsersCoupons::className(), ['coupon_id' => 'id'])->inverseOf('coupon');
    }
}
