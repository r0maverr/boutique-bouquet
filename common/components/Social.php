<?php

namespace common\components;

use yii\httpclient\Client;

class Social
{
    public static function authorizeVK()
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('https://oauth.vk.com/authorize')
            ->setData(['name' => 'John Doe', 'email' => 'johndoe@example.com'])
            ->send();

        if ($response->isOk) {
            $newUserId = $response->data['id'];


        }
}