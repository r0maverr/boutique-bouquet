<?php

namespace frontend\models\coupons;

use frontend\models\Coupons;
use frontend\models\Users;
use Yii;
use yii\base\Model;

class Create extends Model
{
    public $name;
    private $_coupon;

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string'],
            ['name', 'validateName'],
        ];
    }

    public function validateName($attribute)
    {
        if (!$this->hasErrors() && !$this->getCoupon()) {
            $this->addError($attribute, 'Wrong name of coupon!');
        }
    }

    public function validateCoupon()
    {
        $coupon = $this->getCoupon();
        return $coupon->checkEndTime();
    }

    public function afterValidate()
    {
        if (!$this->hasErrors() && !$this->validateCoupon()) {
            $this->addError('time', 'Coupon is already has expired.');
        }
    }

    private function getCoupon()
    {
        if (!$this->_coupon) {
            $this->_coupon = Coupons::findOne(['name' => $this->name]);
        }
        return $this->_coupon;
    }

    public function add()
    {
        /** @var Users $user */
        $user = Yii::$app->user->identity;
        $coupon = $this->getCoupon();
        $user->addCoupon($coupon);
        return $coupon;
    }
}