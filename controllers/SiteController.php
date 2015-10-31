<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

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
        return $this->render('index');
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

    public function actionRegister()
    {
        $request = Yii::$app->request;
        $username = $request->post('username');
        $email = $request->post('email');
        $password = $request->post('password');
        if (empty($username) or empty($email) or empty($password)) {
            $this->setHeader(400);
            echo json_encode(array('status' => 0, 'error_code' => 400, 'message' => 'Missing params'),
                JSON_PRETTY_PRINT);
            exit;
        }

        $db = Yii::$app->db;
        $projectName = $request->post('gbid');
        if (!empty($projectName)) {
            $sql = "SELECT id FROM project WHERE name = :projectName";
            $params = [
                ':projectName' => $projectName,
            ];
            $projectId = $db->createCommand($sql, $params)->queryScalar();
        }
        if (empty($projectId)) {
            $projectId = 0;
        }

        if (strlen($password) < 6 or strlen($password) > 20) {
            $this->setHeader(400);
            echo json_encode(array('status' => 0, 'error_code' => 400, 'message' => 'Password length must in [6, 20]'),
                JSON_PRETTY_PRINT);
            exit;
        }

        $email = trim($email);
        $sql = "SELECT 1 FROM user WHERE email = :email";
        $params = [
            ':email' => $email,
        ];
        $emailExist = $db->createCommand($sql, $params)->queryScalar();
        if ($emailExist) {
            $this->setHeader(400);
            echo json_encode(array('status' => 0, 'error_code' => 400, 'message' => 'Email exists'),
                JSON_PRETTY_PRINT);
            exit;
        }

        $username = trim($username);
        $password = Util::hashPassword(trim($password));
        $sql = "INSERT user (name, password, email, project_id) VALUES (:name, :password, :email, :projectId)";
        $params = [
            ':name' => $username,
            ':password' => $password,
            ':email' => $email,
            ':projectId' => $projectId,
        ];
        $db->createCommand($sql, $params)->execute();

        $sql = "SELECT id user_id, name user_name, project_id FROM user WHERE name = :name";
        $params = [
            ':name' => $username,
        ];
        $data = $db->createCommand($sql, $params)->queryOne();

        $this->setHeader(200);
        echo json_encode(array('status' => 1, 'data' => $data, 'message' => 'Register success'), JSON_PRETTY_PRINT);
        exit;
    }

}
