<?php

namespace frontend\models\site;

use common\models\extended\Users;

use yii;
use yii\base\Model;

class SignUp extends Model
{
    public $type;
    public $name;
    public $email;
    public $phone;
    public $password;

    private $_user;

    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type', 'name', 'email', 'phone', 'password'], 'string'],

            [['type'], 'filter', 'filter' => 'strtoupper'],
            ['type', 'in', 'range' => Users::TYPES],

            ['email', 'email'],
            ['email', 'validateEmail'],

            ['phone', 'match', 'pattern' => '/^\d{11}$/'],
            ['phone', 'validatePhone'],

            ['password', 'string', 'length' => [5, 250]],
        ];
    }

    public function validateEmail($attribute)
    {
        if (!$this->hasErrors()) {
            if (Users::findByVerifiedEmail($this->email)) {
                $this->addError($attribute, 'User with current email is already exists!');
            } else if (Users::findByUnverifiedEmail($this->email)) {
                $this->addError($attribute, 'You are already sign up. Please confirm your email.');
            }
        }
    }

    public function validatePhone()
    {
        if (!$this->hasErrors()) {

        }
    }

    private function getUser()
    {
        if (!$this->_user) {
            $this->_user = Users::findByEmail($this->email);
        }

        return $this->_user;
    }

    public function signUp()
    {
        $type = in_array($this->type, Users::TYPES);

        $this->switch
        $socialID = null;
        $user = Users::signUp($type, $this->name, $this->phone, $this->email, $this->password, $socialID);
        $this->sendEmail($user);

        return $user;
    }

    private function sendEmail($user)
    {
        Yii::$app->mail->compose('confirmEmail',
            [
                'user' => $user,
                'link' => Yii::$app->params['settings']['frontUrl'] . '/site/confirm-email/' . $user->email_verify_token
            ])
            ->setFrom(Yii::$app->params['settings']['supportEmail'])
            ->setTo($this->email)
            ->setSubject('Подтверждение почты | ' . Yii::$app->params['settings']['serviceName'])
            ->send();
    }
}