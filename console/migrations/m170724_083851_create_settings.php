<?php

use yii\db\Migration;

class m170724_083851_create_settings extends Migration
{
    public function up()
    {
        $this->insert('settings', [
            'name' => 'serviceName',
            'alias' => 'serviceName',
            'value' => 'Flowers Delivery',
        ]);
        $this->insert('settings', [
            'name' => 'supportEmail',
            'alias' => 'supportEmail',
            'value' => 'test.flow.del@yandex.ru',
        ]);
        $this->insert('settings', [
            'name' => 'frontUrl',
            'alias' => 'frontUrl',
            'value' => 'flowers-delivery.com',
        ]);

        $this->insert('settings', [
            'name' => 'vkClientID',
            'alias' => 'vkClientID',
            'value' => '6125226',
        ]);
    }

    public function down()
    {
        $this->delete('settings', ['name' => 'serviceName']);
        $this->delete('settings', ['name' => 'supportEmail']);
        $this->delete('settings', ['name' => 'frontUrl']);
        $this->delete('settings', ['name' => 'vkClientID']);
    }
}
