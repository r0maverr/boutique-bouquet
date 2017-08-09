<?php

namespace frontend\models\site;

use frontend\models\Users;
use Yii;
use yii\base\Model;

class Login extends Model
{
    public $type;
    public $email;
    public $password;

    private $_user;

    public function rules()
    {
        return [
            ['type', 'required'],
            [['type', 'email', 'password'], 'string'],
            ['type', 'in', 'range' => Users::TYPES],
            ['type', 'validateType'],
        ];
    }

    public function validationType()
    {

    }

    private function getUser()
    {
        if (!$this->_user) {
            $this->_user = Users::findByEmail($this->email);
        }
        return $this->_user;
    }

    public function login()
    {
        $this->_user;
    }
}