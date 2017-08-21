<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners".
 *
 * @property integer $id
 * @property string $type
 * @property string $desc
 * @property string $cities
 * @property string $site
 * @property string $social
 * @property string $img_logotype
 * @property string $img_shop
 * @property string $img_team
 * @property integer $status
 *
 * @property Branches[] $branches
 * @property Merchants[] $merchants
 * @property Products[] $products
 */
class Partners extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'cities'], 'required'],
            [['status'], 'integer'],
            [['type'], 'string', 'max' => 31],
            [['desc', 'cities', 'site', 'social', 'img_logotype', 'img_shop', 'img_team'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'desc' => 'Desc',
            'cities' => 'Cities',
            'site' => 'Site',
            'social' => 'Social',
            'img_logotype' => 'Img Logotype',
            'img_shop' => 'Img Shop',
            'img_team' => 'Img Team',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branches::className(), ['partner_id' => 'id'])->inverseOf('partner');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMerchants()
    {
        return $this->hasMany(Merchants::className(), ['partner_id' => 'id'])->inverseOf('partner');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['partner_id' => 'id'])->inverseOf('partner');
    }
}
