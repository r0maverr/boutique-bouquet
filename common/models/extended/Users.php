<?php

namespace common\models\extended;

use yii;

/**
 * @property string $email_verify_token
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $fcm_token
 *
 * @property Coupons $coupons
 *
 */
class Users extends \common\models\Users
{
    const STATUS_EMAIL_UNVERIFIED = 0;
    const STATUS_PASSWORD_RESETED = 1;
    const STATUS_SOCIAL_UNACTIVE = 2;
    const STATUS_ACTIVE = 10;

    const TYPE_EMAIL = 0;
    const TYPE_VK = 2;
    const TYPE_FB = 4;
    const TYPE_INST = 8;
    const TYPES = [
        self::TYPE_EMAIL => 'EMAIL',
        self::TYPE_VK => 'VK',
        self::TYPE_FB => 'FB',
        self::TYPE_INST => 'INST'
    ];

    public function getCoupons(){
        return Coupons::find()
            ->leftJoin('users_coupons', 'users_coupons.user_id = users.id')
            ->where(['users.id' => $this->id])
            ->all();
    }

    public static function findByEmail($email)
    {
        return self::findOne(['email' => $email]);
    }

    public function getEmail_verify_token()
    {
        $token = Tokens::findOne(['user_id' => $this->id, 'type' => Tokens::TYPE_EMAIL_VERIFY_TOKEN]);
        return $token ? $token->value : null;
    }

    public function setEmail_verify_token($value)
    {
        Tokens::updateOrCreateOrDelete($this->id, Tokens::TYPE_EMAIL_VERIFY_TOKEN, $value);
    }

    public function getAuth_key()
    {
        $token = Tokens::findOne(['user_id' => $this->id, 'type' => Tokens::TYPE_AUTH_KEY]);
        return $token ? $token->value : null;
    }

    public function setAuth_key($value)
    {
        Tokens::updateOrCreateOrDelete($this->id, Tokens::TYPE_AUTH_KEY, $value);
    }

    public function getPassword_reset_token()
    {
        $token = Tokens::findOne(['user_id' => $this->id, 'type' => Tokens::TYPE_PASSWORD_RESET_TOKEN]);
        return $token ? $token->value : null;
    }

    public function setPassword_reset_token($value)
    {
        Tokens::updateOrCreateOrDelete($this->id, Tokens::TYPE_PASSWORD_RESET_TOKEN, $value);
    }

    // TODO: need to think about realization FCM tokens

    public function getFcmTokens()
    {
        $token = Tokens::findOne(['user_id' => $this->id, 'type' => Tokens::TYPE_FCM_TOKEN]);
        return $token ? $token->value : null;
    }

    public function setFcm_token($value)
    {
        Tokens::create($this->id, Tokens::TYPE_FCM_TOKEN, $value);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findByBearerToken($token);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateEmailVerifyToken()
    {
        $this->email_verify_token = Yii::$app->security->generateRandomString();
    }

    public static function findByEmailVerifyToken($token)
    {
        $token = Tokens::findOne(['type' => Tokens::TYPE_EMAIL_VERIFY_TOKEN, 'value' => $token]);
        return $token !== null ? self::findOne($token->user_id) : null;
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString();
    }

    public static function findByResetPasswordToken($token)
    {
        $token = Tokens::findOne(['type' => Tokens::TYPE_PASSWORD_RESET_TOKEN, 'value' => $token]);
        return $token !== null ? $token->user : null;
    }

    public static function findByUnverifiedEmail($email)
    {
        return self::findOne(['email' => $email, 'status' => self::STATUS_EMAIL_UNVERIFIED]);
    }

    public static function findByVerifiedEmail($email)
    {
        return self::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPhone($phone)
    {
        return self::findOne(['phone' => $phone]);
    }

    /** return Users|null */
    public static function signUp($type, $name, $phone, $email, $password, $socialID)
    {
        $user = self::findByEmail($email);

        // new user
        if (!$user) {
            $user = new self();

            $user->registration_type = $type;
            $user->name = $name;
            $user->phone = $phone;
            $user->email = $email;
            $user->password_hash = Yii::$app->security->generatePasswordHash($password);

            $user->status = self::STATUS_EMAIL_UNVERIFIED;

            if (!$user->save()) {
                throw new yii\web\ServerErrorHttpException('Can\'t create new user.');
            }

            $user->generateEmailVerifyToken();
            $user->generateAuthKey();

            return $user;

            // sign another one time
        } else if ($user === self::findByUnverifiedEmail($email)) {
            return $user;

        } else {
            throw new yii\web\BadRequestHttpException('User with current email is already exist.');
        }
    }

    public function confirm()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->email_verify_token = null;
        if (!$this->save()) {
            throw new yii\web\ServerErrorHttpException('Can\'t find user.');
        }

        return $this;
    }

    public function addCoupon(Coupons $coupon)
    {
        $userCoupon = new UsersCoupons();
        $userCoupon->user_id = $this->id;
        $userCoupon->coupon_id = $coupon->id;
        if (!$userCoupon->save()) {
            throw new yii\web\ServerErrorHttpException('Can\'t save userCoupon in db!');
        }
    }
}
