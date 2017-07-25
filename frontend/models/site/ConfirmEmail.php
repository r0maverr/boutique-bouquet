<?php

namespace frontend\models\site;

use common\models\extended\Users;

use yii;
use yii\base\Model;

class ConfirmEmail extends Model
{
    public $email_verify_token;

    private $_user;

    public function rules()
    {
        return [
            ['email_verify_token', 'required'],
            ['email_verify_token', 'string'],
            ['email_verify_token', 'validateEmailVerifyToken'],
        ];
    }

    public function validateEmailVerifyToken($attribute)
    {
        if (!$this->hasErrors() && !$this->getUser()) {
            $this->addError($attribute, 'Can\'t find user by email verify token.');
        }
    }

    private function getUser()
    {
        if (!$this->_user) {
            $this->_user = Users::findByEmailVerifyToken($this->email_verify_token);
        }

        return $this->_user;
    }

    public function confirmEmail()
    {
        $user = $this->getUser();
        $user->confirm();
        return $user;
    }
}