<?php

namespace frontend\controllers;

use frontend\models\user\Edit;
use yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'edit'],
                'rules' => [
                    [
                        'actions' => ['index', 'edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'edit' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'user' => Yii::$app->user->identity
        ]);
    }

    public function actionEdit()
    {
        $model = new Edit();
        $model->load(Yii::$app->request->post(), '');
        if ($model->validate()) {
            return $model;
        }

        $user = $model->edit();
        return $this->render('index', ['user' => $user]);
    }
}
