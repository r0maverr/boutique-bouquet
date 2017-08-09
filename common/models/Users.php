<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property integer $registration_type
 * @property string $name
 * @property integer $phone
 * @property string $email
 * @property string $socialID
 * @property string $password_hash
 * @property integer $status
 *
 * @property Tokens[] $tokens
 * @property UsersCoupons[] $usersCoupons
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['registration_type', 'name'], 'required'],
            [['registration_type', 'phone', 'status'], 'integer'],
            [['name', 'email', 'socialID'], 'string', 'max' => 31],
            [['password_hash'], 'string', 'max' => 255],
            [['phone'], 'unique'],
            [['email'], 'unique'],
            [['socialID'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'registration_type' => 'Registration Type',
            'name' => 'Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'socialID' => 'Social ID',
            'password_hash' => 'Password Hash',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(Tokens::className(), ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersCoupons()
    {
        return $this->hasMany(UsersCoupons::className(), ['user_id' => 'id'])->inverseOf('user');
    }
}
