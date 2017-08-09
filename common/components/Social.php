<?php

namespace common\components;

use yii;
use yii\httpclient\Client;

class Social
{
    public static function generateAuthorizeUrlVK(){
        return 'https://oauth.vk.com/authorize'
            . '?client_id=' . Yii::$app->params['settings']['vkClientID']
            . '&redirect_uri=' . 'yandex.ru'
            . '&display=page'
            . '&scope=email%26offline%26photos'
            . '&response_type=code&v=5.67'
            . '&state=success';
    }

    public static function getAccessTokenVk($code)
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('https://oauth.vk.com/access_token')
            ->setOptions([
                'client_id' => Yii::$app->params['setting']['vkClientID'],
                'client_secret' => Yii::$app->params['setting']['vkClientSecret'],
                'redirect_uri' => yii\helpers\Url::toRoute(['site/access-token-vk']),
                'code' => $code,
            ])
            ->send();

        if (!$response->isOk) {
            throw new yii\web\ServerErrorHttpException('Can\'t send request to get access token from VK.');
        }

        return $response;
    }
}