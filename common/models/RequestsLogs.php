<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "requests_logs".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $controller
 * @property string $action
 * @property string $method
 * @property string $request
 * @property string $response
 * @property string $error
 * @property string $device
 * @property string $timestamp
 */
class RequestsLogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'requests_logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['controller', 'action'], 'required'],
            [['request', 'response', 'error', 'device'], 'string'],
            [['timestamp'], 'safe'],
            [['controller', 'action', 'method'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'controller' => 'Controller',
            'action' => 'Action',
            'method' => 'Method',
            'request' => 'Request',
            'response' => 'Response',
            'error' => 'Error',
            'device' => 'Device',
            'timestamp' => 'Timestamp',
        ];
    }
}
