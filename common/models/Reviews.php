<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $client_name
 * @property integer $partner_id
 * @property string $partner_name
 * @property integer $product_id
 * @property string $product_name
 * @property integer $date
 * @property string $detailed_estimate
 * @property integer $estimate
 * @property string $text
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'partner_id', 'product_id', 'date', 'estimate'], 'integer'],
            [['date', 'estimate'], 'required'],
            [['client_name', 'partner_name', 'product_name', 'detailed_estimate', 'text'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'client_name' => 'Client Name',
            'partner_id' => 'Partner ID',
            'partner_name' => 'Partner Name',
            'product_id' => 'Product ID',
            'product_name' => 'Product Name',
            'date' => 'Date',
            'detailed_estimate' => 'Detailed Estimate',
            'estimate' => 'Estimate',
            'text' => 'Text',
        ];
    }
}
