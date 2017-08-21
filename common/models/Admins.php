<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admins".
 *
 * @property integer $id
 * @property integer $login
 * @property integer $password_hash
 */
class Admins extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admins';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'login', 'password_hash'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password_hash' => 'Password Hash',
        ];
    }
}
