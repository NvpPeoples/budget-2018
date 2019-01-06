<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Pays;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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
                    'logout' => ['post'],
                ],
            ],
        ];
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
        $groups =  (new \yii\db\Query())
            ->select([
                'c.id',
                'c.name',
                'c.icon',
                new \yii\db\Expression('count(*) as cnt'),
                new \yii\db\Expression('round(sum(amount), 2) as amount')
            ])
            ->from(['a' => Pays::tableName(), 'b' => 'ttypes', 'c' => 'g_types'])
            ->where([
                'and',
                'a.id = b.tranz_id',
                'b.type_id = c.id'
            ])
            ->groupBy(['c.id', 'c.name'])
            ->orderBy(['amount' => SORT_DESC])
            ->limit(5)
            ->all();

        $orgs =  (new \yii\db\Query())
            ->select([
                'c.id',
                'c.name',
                new \yii\db\Expression('count(*) as cnt'),
                new \yii\db\Expression('round(sum(amount), 2) as amount')
            ])
            ->from(['a' => Pays::tableName(), 'b' => 'torgs', 'c' => 'g_orgs'])
            ->where([
                'and',
                'a.id = b.tranz_id',
                'b.org_id = c.id'
            ])
            ->groupBy(['c.id', 'c.name'])
            ->orderBy(['amount' => SORT_DESC])
            ->limit(10)
            ->all();


        return $this->render('index', [
            'groups' => $groups,
            'orgs'   => $orgs,
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
