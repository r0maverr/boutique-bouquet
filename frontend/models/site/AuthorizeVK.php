<?php

namespace frontend\models\site;

use common\components\Social;
use common\models\extended\Users;

use yii;
use yii\base\Model;

class AuthorizeVK extends Model
{
    public $code;
    public $error;
    public $error_description;

    private $_user;

    public function rules()
    {
        return [
            [['code', 'error', 'error_description'], 'string'],
        ];
    }


    public function afterValidate()
    {
        if (!$this->hasErrors() && (!isset($this->code) || $this->code == null)) {
            $this->addError('error', $this->error . ': ' . $this->error_description);
        }
    }

    private function getUser()
    {
        if (!$this->_user) {
            $this->_user = Users::findByEmail($this->email);
        }

        return $this->_user;
    }

    public function authorize()
    {
        $user = new Users();
        $user->status = Users::STATUS_SOCIAL_UNACTIVE;
        if (!$user->save()) {
            throw new yii\web\ServerErrorHttpException('Can\'t create new user.');
        }

        Social::getAccessTokenVk($this->code);
    }
}