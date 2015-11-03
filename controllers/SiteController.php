<?php

namespace app\controllers;

use app\models\Verify;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ContactForm;
use app\components\Util;
use app\models\User;

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
        /* 获取到前一次进来页面 并存入session */
        $url = '';
        if (isset($_SERVER['HTTP_REFERER'])) {
            $url = $_SERVER['HTTP_REFERER'];
        }
        Yii::$app->session->set('url', $url);
        /* 获取到前一次进来页面  */

        $this->view->title = 'dskies';
        return $this->render('index');
    }

    public function actionValidMobile()
    {
        $res = false;
        $mobile = trim(Yii::$app->request->post('mobile'));
        $mobile && $userInfo = User::find()->where(['mobile' => $mobile])->one();
        $userInfo && !empty($userInfo) && $res = true;
        return $res;
    }

    public function actionValidEmail()
    {
        $res = false;
        $email = trim(Yii::$app->request->post('email'));
        $email && $userInfo = User::find()->where(['email' => $email])->one();
        $userInfo && !empty($userInfo) && $res = true;
        return $res;
    }

    public function actionLogin()
    {
        $username = trim(Yii::$app->request->post('username'));
        $password = trim(Yii::$app->request->post('password'));
        $res = [];
        if (empty($username) || empty($password)) {
            $res['code'] = -1;
            $res['msg'] = '账号或密码不能为空';
            echo json_encode($res);
            exit;
        }
        $arr = [];
        if (strpos($username, '@') === false) {
            $arr['mobile'] = $username;
        } else {
            $arr['email'] = $username;
        }
        $arr['password'] = $password;
        $userInfo = User::find()->where($arr)->one();
        if ($userInfo && !empty($userInfo)) {
            Yii::$app->session->set('userId', $userInfo['id']);
            Yii::$app->session->set('userName', $userInfo['given_name'] . $userInfo['family_name']);
            $res['code'] = 0;
            $res['msg'] = '登录成功';
            $res['url'] = Yii::$app->session->get('url');
            echo json_encode($res);
            exit;
        } else {
            $res['code'] = -1;
            $res['msg'] = '账号或密码错误';
            echo json_encode($res);
            exit;
        }
    }

    public function actionSession()
    {
        return $this->render('session');
    }

    public function actionLogout()
    {
        /*
        Yii::$app->user->logout();
        return $this->goHome();
        */
        Yii::$app->session->remove('userId');
        Yii::$app->session->remove('userName');
        Yii::$app->session->remove('url');
        return $this->redirect('/site/session');
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSendCode()
    {
        $request = Yii::$app->request;
        $mobile = $request->post('mobile');
        if (empty($mobile)) {
            echo json_encode(array('status' => 0, 'error_code' => 400, 'message' => 'Missing mobile'),
                JSON_PRETTY_PRINT);
            exit;
        }
        //todo verify mobile number
        $verify = Verify::find()->where(['mobile' => $mobile])->one();
        if (empty($verify)) {
            $verify = new Verify();
            $verify->mobile = $mobile;
            $verify->save();
        }
        $code = Util::generateString(4);
        $verify->code = $code;
        $verify->save();

        //todo retry
        $success = Util::sendSMS($verify->mobile, $verify->code);
        echo json_encode([
            'status' => $success,
        ], JSON_PRETTY_PRINT);
        exit;
    }

    public function actionRegister()
    {
        $request = Yii::$app->request;
        $password = $request->post('password');
        $givenName = $request->post('givenName');
        $familyName = $request->post('familyName');
        $specialization = $request->post('specialization');
//        $portfolio = $request->post('portfolio');
        $email = $request->post('email');
        $mobile = $request->post('mobile');
        $code = $request->post('code');
        if (empty($password) or empty($givenName) or empty($familyName) or empty($specialization) or empty($email)
            or empty($mobile) or empty($code)
        ) {
            echo json_encode(array('status' => 0, 'error_code' => 400, 'message' => 'Missing params'),
                JSON_PRETTY_PRINT);
            exit;
        }

        $db = Yii::$app->db;
        $verify = Verify::find()->where(['mobile' => $mobile])->one();
        if (empty($verify)) {
            echo json_encode([
                'status' => 0,
                'message' => 'Wrong verify message',
            ], JSON_PRETTY_PRINT);
        }
        if ($code != $verify->code) {
            echo json_encode([
                'status' => 0,
                'message' => 'Wrong verify message',
            ], JSON_PRETTY_PRINT);

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
            echo json_encode(array('status' => 0, 'error_code' => 400, 'message' => 'Email exists'),
                JSON_PRETTY_PRINT);
            exit;
        }

        $phoneExist = $db->createCommand("SELECT 1 FROM user WHERE mobile = :mobile",
            [':mobile' => $mobile])->queryScalar();
        if ($phoneExist) {
            echo json_encode(array('status' => 0, 'error_code' => 400, 'message' => 'Mobile exists'),
                JSON_PRETTY_PRINT);
            exit;
        }

        $givenName = trim($givenName);
        $familyName = trim($familyName);
        $password = Util::hashPassword(trim($password));
        $user = new User();
        $user->password = $password;
        $user->given_name = $givenName;
        $user->family_name = $familyName;
        $user->specialization = $specialization;
        $user->email = $email;
        $user->mobile = $mobile;
        $user->is_verified = 1;
        $user->save();

        echo json_encode(array('status' => 1, 'message' => 'Register success'), JSON_PRETTY_PRINT);
        exit;
    }

}
