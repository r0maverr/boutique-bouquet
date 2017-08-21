<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "branches".
 *
 * @property integer $id
 * @property string $address
 * @property string $phone_sms
 * @property string $phone_client
 * @property string $email
 * @property string $work_time
 * @property string $delivery_time
 * @property integer $partner_id
 *
 * @property Partners $partner
 * @property Merchants[] $merchants
 */
class Branches extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'branches';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_time', 'delivery_time'], 'required'],
            [['partner_id'], 'integer'],
            [['address', 'phone_sms', 'phone_client', 'email', 'work_time', 'delivery_time'], 'string', 'max' => 255],
            [['partner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partners::className(), 'targetAttribute' => ['partner_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'phone_sms' => 'Phone Sms',
            'phone_client' => 'Phone Client',
            'email' => 'Email',
            'work_time' => 'Work Time',
            'delivery_time' => 'Delivery Time',
            'partner_id' => 'Partner ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partners::className(), ['id' => 'partner_id'])->inverseOf('branches');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchants()
    {
        return $this->hasMany(Merchants::className(), ['branch_id' => 'id'])->inverseOf('branch');
    }
}
