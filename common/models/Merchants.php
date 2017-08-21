<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "merchants".
 *
 * @property integer $id
 * @property string $name
 * @property integer $phone
 * @property integer $type
 * @property integer $partner_id
 * @property integer $branch_id
 * @property integer $is_active
 *
 * @property Branches $branch
 * @property Partners $partner
 */
class Merchants extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merchants';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['phone', 'type', 'partner_id', 'branch_id', 'is_active'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::className(), 'targetAttribute' => ['branch_id' => 'id']],
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
            'name' => 'Name',
            'phone' => 'Phone',
            'type' => 'Type',
            'partner_id' => 'Partner ID',
            'branch_id' => 'Branch ID',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branches::className(), ['id' => 'branch_id'])->inverseOf('merchants');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partners::className(), ['id' => 'partner_id'])->inverseOf('merchants');
    }
}
