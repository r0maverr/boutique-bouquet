<?php

namespace frontend\models\site;

use yii;
use yii\base\Model;

class AcсessTokenVK extends Model
{
    public $access_token;
    public $error;
    public $error_description;

    private $_user;

    public function rules()
    {
        return [
            [['access_token', 'error', 'error_description'], 'string'],
        ];
    }

    public function afterValidate()
    {
        if (!$this->hasErrors()
            && (!isset($this->access_token) || $this->access_token == null)
        ) {
            $this->addError('error', $this->error . ': ' . $this->error_description);
        }
    }

    public function getResponse()
    {
        $response = new \stdClass();
        $response->access_token = $this->access_token;
        return $response;
    }
}