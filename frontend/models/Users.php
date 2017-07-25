<?php

namespace restapi\models;

use yii;
use common\models\extended\UsersIdentity;
/**
 * Class Users
 * @package restapi\models
 *
 * @property BookedRooms $bookedRooms
 */
class Users extends \common\models\extended\Users
{
    public function getBookedRooms()
    {
        return $this->hasMany(BookedRooms::className(), ['user_id' => 'id'])->inverseOf('user');
    }

    public $newRecord = null;

    public function beforeSave($insert)
    {
        ($this->isNewRecord) ? $this->newRecord = true : $this->newRecord = false;

        return parent::beforeSave($insert);
    }

    public static function signUp($name, $phone, $company_name, $email, $password)
    {
        $user = self::findByEmail($email);

        if (empty($user)) {
            $user = new self();

            $user->name = $name;
            $user->phone = $phone;
            $user->company_name = $company_name;
            $user->email = $email;
            $user->password_hash = Yii::$app->security->generatePasswordHash($password);

            $user->role = self::ROLE_USER;
            $user->status = self::STATUS_EMAIL_UNVERIFIED;
            $user->is_push_available = true;

            if (!$user->save()) {
                throw new yii\web\ServerErrorHttpException('Can\'t create new user.');
            }

            $user->generateEmailVerifyToken();

            return $user;
        } else {
            $user = self::findByUnverifiedEmail($email);

            if (!empty($user)) {

                $user->generateEmailVerifyToken();

                return $user;
            } else {
                throw new yii\web\BadRequestHttpException('User with current email is already exist.');
            }
        }
    }

    public function confirmAndLogin()
    {
        $this->status = self::STATUS_ACTIVE;

        if (!$this->save()) {
            throw new yii\web\ServerErrorHttpException('Can\'t update status of user.');
        }

        $this->email_verify_token = null;
        $this->generateAuthKey();
        $this->generateBearerToken();

        Yii::$app->user->login($this);
    }

    public function login()
    {
        $this->generateAuthKey();
        $this->generateBearerToken();
        $this->save();

        Yii::$app->user->login($this);
    }

    public function logout()
    {
        Yii::$app->user->logout();
    }

    public function resetPassword()
    {
        $this->password_hash = null;
        $this->status = self::STATUS_PASSWORD_RESETED;
        $this->save();

        $this->generatePasswordResetToken();
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        $this->save();

        $this->password_reset_token = null;
    }

    public function edit($name, $phone, $email, $company_name)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->company_name = $company_name;

        if ($this->email !== $email) {
            $this->email = $email;
            $this->status = $this::STATUS_EMAIL_UNVERIFIED;

            $this->generateEmailVerifyToken();
        }

        if (!$this->save()) {
            throw new yii\web\ServerErrorHttpException('Can\'t edit mail.');
        }
    } // TODO: email link : done!

    public function editAndConfirmEmail($name, $phone, $email, $company_name)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->company_name = $company_name;

        if ($this->email !== $email) {
            $this->email = $email;
        }

        if (!$this->save()) {
            throw new yii\web\ServerErrorHttpException('Can\'t edit mail.');
        }
    }

    public function userResponse()
    {
        $result = new \stdClass();
        $result->id = (string)$this->id;
        $result->name = $this->name;
        $result->phone = $this->phone;
        $result->email = $this->email;
        $result->company_name = $this->company_name;
        $result->status = $this->status;
        $result->is_push_available = (boolean)$this->is_push_available;
        $result->role = self::ROLES[$this->role];
        $result->ar_number = $this->ar_number;
        $result->bearer_token = $this->bearer_token;
        return $result;
    }

    public static function searchCompanies($text)
    {
        return self::find()
            ->select('company_name')->distinct()
            ->where(['like', 'company_name', $text])
            ->orderBy('company_name')
            ->column();
    }
}
