<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $photos
 * @property string $name
 * @property integer $price
 * @property integer $discount
 * @property integer $discount_type
 * @property string $composition
 * @property integer $width
 * @property integer $height
 * @property integer $time
 * @property integer $type
 * @property string $tags
 * @property string $description
 * @property integer $partner_id
 * @property integer $status
 *
 * @property Partners $partner
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'width', 'height', 'time', 'type', 'description', 'partner_id', 'status'], 'required'],
            [['price', 'discount', 'discount_type', 'width', 'height', 'time', 'type', 'partner_id', 'status'], 'integer'],
            [['photos', 'name', 'composition', 'tags', 'description'], 'string', 'max' => 255],
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
            'photos' => 'Photos',
            'name' => 'Name',
            'price' => 'Price',
            'discount' => 'Discount',
            'discount_type' => 'Discount Type',
            'composition' => 'Composition',
            'width' => 'Width',
            'height' => 'Height',
            'time' => 'Time',
            'type' => 'Type',
            'tags' => 'Tags',
            'description' => 'Description',
            'partner_id' => 'Partner ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partners::className(), ['id' => 'partner_id'])->inverseOf('products');
    }
}
