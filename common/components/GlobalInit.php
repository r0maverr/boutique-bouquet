<?php

namespace common\components;

use common\models\extended\Settings;
use yii;

class GlobalInit extends \yii\base\Component
{
    public function init()
    {
        $settings = Yii::$app->db->schema->getTableSchema('settings');

        if ($settings !== null) {
            \Yii::$app->params['settings'] = Settings::getList();
        }
        parent::init();
    }
}