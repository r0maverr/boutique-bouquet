<?php

namespace common\models\extended;

use Yii;

class Coupons extends \common\models\Coupons
{
    const TYPE_MONEY = 0;
    const TYPE_PERCENT = 5;
    const TYPES = [
        self::TYPE_MONEY => 'TYPE_MONEY',
        self::TYPE_PERCENT => 'TYPE_PERCENT'
    ];

    public function checkEndTime()
    {
        if(time() > $this->end_time){
            return false;
        }
        return true;
    }
}