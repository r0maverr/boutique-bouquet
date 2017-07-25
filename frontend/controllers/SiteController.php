<?php

namespace frontend\controllers;

use frontend\models\site\ConfirmEmail;
use frontend\models\site\SignUp;
use yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'sign-up'],
                'rules' => [
                    [
                        'actions' => ['sign-up'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'sign-up' => ['post'],
                    'login' => ['post'],
                    'logout' => ['post'],
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
        return $this->render('index');
    }

    public function actionSignUp()
    {
        $model = new SignUp();
        $model->load(Yii::$app->request->post(), '');
        if (!$model->validate()) {

            echo '<pre>';
            print_r($model->errors);
            echo '</pre>';
            die();

            return $model;
        }
        $model->signUp();

        echo '<pre>';
        print_r($model);
        echo '</pre>';
        die();

        return $this->render('index');
    }

    public function actionConfirmEmail()
    {
        $model = new ConfirmEmail();
        $model->load(Yii::$app->request->post(), '');
        if (!$model->validate()) {

            echo '<pre>';
            print_r($model->errors);
            echo '</pre>';
            die();

            return $model;
        }
        $model->confirmEmail()

        ;

        echo '<pre>';
        print_r($model);
        echo '</pre>';
        die();

        return $this->render('index');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
    }
}
