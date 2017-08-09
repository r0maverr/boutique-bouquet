<?php

namespace frontend\models\user;

use frontend\models\Users;
use yii;
use yii\base\Model;

class Edit extends Model
{
    public $name;
    public $phone;

    private $_user;

    public function rules()
    {
        return [
            [['name', 'phone'], 'string'],
        ];
    }

    public function edit()
    {
        /** @var Users $user */
        $user = $this->getUser();
        $user->name = $this->name;
        $user->phone = $this->phone;
        if (!$user->save()) {
            throw new yii\web\ServerErrorHttpException('Can\'t save user in db.');
        }
        return $user;
    }

    private function getUser()
    {
        if (!$this->_user) {
            $this->_user = Yii::$app->user->identity;
        }
        return $this->_user;
    }
}