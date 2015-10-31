<?php

class SiteController extends Controller {

    public $layout = 'homeMain';
    public $subNav;

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionRegister() {
        if (Yii::app()->request->isAjaxRequest) {
            if (!empty($_POST)) {
                $title = Util::t('userRegister');
                $data = serialize(Yii::app()->params->memberData);
                $post = $_POST;
                $generateString = Util::generateString(6);
                $email_time = date('Y-m-d H:i:s');
                if ($post['username'] && $post['email'] && $post['password']) {
                    $email = trim($post['email']);
                    if (strlen($post['password']) < 6 || strlen($post['password']) > 20) {
                        $msg = Util::t('passwordLength');
                        echo CJSON::encode(compact('ok', 'title', 'msg'));
                        exit();
                    }
                    $password = Member::hashPassword(trim($post['password']));
                    if ($email == 'other') {
                        $email = $post['email_str_res'] . $post['email_str_right'];
                    }
                    //用户名是否注册
                    $member_res = Member::model()->find('name = :name', array(':name' => $post['username']));
                    if ($member_res) {
                        $msg = Util::t('usernameIsHave');
                        echo CJSON::encode(compact('ok', 'title', 'msg'));
                        exit();
                    }
                    //邮箱是否注册
                    $member_res = Member::model()->find('email = :email', array(':email' => $email));
                    if ($member_res) {
                        $msg = Util::t('emailIsHave');
                        echo CJSON::encode(compact('ok', 'title', 'msg'));
                        exit();
                    }
                    $shop = Shop::model()->find('name=:name', array(':name' => trim($post['username'])));
                    if (!$shop) {
                        $msg = Util::t('shopIsNull');
                        echo CJSON::encode(compact('ok', 'title', 'msg'));
                        exit();
                    }

                    $userName = trim($post['username']);

                    $memberRegister = new MemberRegister();
                    $memberRegister->name = $userName;
                    $memberRegister->email = $email;
                    $memberRegister->data = $data;
                    $memberRegister->email_auth = $generateString;
                    $memberRegister->password = $password;
                    $memberRegister->security = $post['security'];
                    $memberRegister->mobile = $post['mobile'];
                    $memberRegister->phone = $post['phone'];
                    $memberRegister->email_time = $email_time;
                    $res = $memberRegister->insert();
                    $id = $memberRegister->mid;
                        
                    $key = md5($userName . $password . $email . $email_time . $generateString);
                    $activateUrl = Yii::app()->request->hostInfo . "/site/registerVerify/id/{$id}/key/{$key}";
                    $companyName = $shop->company;
                    $mail = Mailer::sent($email, Mailer::prepareSubject('register'), $this->renderPartial('/emailTemplates/register', compact('companyName', 'activateUrl'), true));

                    if ($res && $mail) {
                        $msg = Yii::t('Site', 'registerDone');
                        $ok = TRUE;
                    } else {
                        $msg = Util::t('dbOperateError');
                    }
                } else {
                    $msg = Util::t('dataFormatError');
                }
                echo CJSON::encode(compact('ok', 'title', 'msg'));
            }
        } else {
            $this->render('register');
        }
    }

    public function actionRegisterVerify() {
        $key = isset($_GET['key']) && $_GET['key'] ? $_GET['key'] : '';
        $id = isset($_GET['id']) && $_GET['id'] ? $_GET['id'] : 0;
        $title = Util::t('regEmailValidate');
        if ($key && $id) {
            $mr = MemberRegister::model()->find('mid=:mid', array(':mid' => (int) $id));
            if ($mr) {
                $name = $mr->name;
                $email = $mr->email;
                $email_auth = $mr->email_auth;
                $data = $mr->data;
                $password = $mr->password;
                $security = $mr->security;
                $mobile = $mr->mobile;
                $phone = $mr->phone;
                $email_time = $mr->email_time;
                $key_db = md5($name . $password . $email . $email_time . $email_auth);
                if (time() - strtotime($email_time) > Yii::app()->params->emailUrlEffectTime * 60) {//30分钟失效
                    $msg = Util::t('overtimeLink');
                } else {
                    if ($key == $key_db) { //key对比
                        $member_res = Member::model()->find('name=:name', array(':name' => $name));
                        $now_time = date('Y-m-d H:i:s');
                        $expire_time = date("Y-m-d H:i:s", strtotime("+" . Yii::app()->params->probationTime . " day"));
                        if (!$member_res) {//是否已经注册过
                            $member = new Member();
                            $member->name = $name;
                            $member->data = $data;
                            $member->password = $password;
                            $member->email = $email;
                            $member->security = $security;
                            $member->mobile = $mobile;
                            $member->phone = $phone;
                            $member->created = $now_time;
                            $member->expire_time = $expire_time;
                            $request = Yii::app()->request;
                            $nim = $request->cookies['nim']->value;
                            $inviterId = Yii::app()->db->createCommand("SELECT mid FROM rakuten.member m where mid=:mid")->queryScalar(array(':mid' =>  $nim));
                            if($inviterId){
                                $member->inviter = $inviterId;
                            }
                            $src = $request->cookies['src']->value;
                            $member->source = $src;
                            $res = $member->insert();


                            if ($res) {
                                $client = Client::model()->find("name = '$name'");
                                $client->setCreaterId($member->mid);
                                $client->save();

                                $shop = Shop::model()->find('name = :name', array(':name' => $member->name));
                                $shop_id1 = $shop->shop_id;
                                $shop_id2 = Yii::app()->params['trialDefaultShopId'];
                                $shop_id3 = Yii::app()->params['trialMarketingShopId'];
                                $sql = "insert notice_shop (mid, shop_id, shop_flag, marketing_flag, insert_time, marketing_time) values
(:mid, :shop_id1, 1, 0, now(), 0), (:mid, :shop_id2, 1, 0, now(), 0), (:mid, :shop_id3, 0, 1, 0, now())";
                                Yii::app()->db->createCommand($sql)->execute(array(":mid" => $member->mid, ":shop_id1" => $shop_id1, ":shop_id2" => $shop_id2, ":shop_id3" => $shop_id3));

                                $noticeCatalog = new NoticeCatalog();
                                $noticeCatalog->mid = $member->mid;
                                $noticeCatalog->name = Yii::app()->params['defaultNoticeCatalogName'];
                                $noticeCatalog->insert();

                                Member::assignAuth($member->mid, 'TrialMember');
                                $this->noticeMainCategory($member->mid);
                                $msg = Util::t('validateSuccess');
                                $this->redirect(Yii::app()->request->baseUrl . '/site/login');
                            } else {
                                $msg = Util::t('dbOperateError');
                            }
                            
                            #添加销售日志
                            $client = Client::model()->find('name=:name', array(':name'=>$member->name));
                            $clientlog = ClientLog::getClientLog($client->id, date("Y-m-d"), $client->sales_id);
                            $clientlog->status = 3;  #开通试用
                            $clientlog->save(false);
                        } else {
                            $msg = Util::t('emailHaveValidate');
                        }
                    } else {
                        $msg = Util::t('noEffectLink');
                    }
                }
            } else {
                $msg = Util::t('noEffectLink');
            }
        } else {
            $msg = Util::t('dataFormatError');
        }
        $this->render('commomRes', compact('msg', 'title'));
    }

    public function actionRegisterDone() {
        $this->render('registerDone');
    }

    public function actionFindPassword() {
        if (Yii::app()->request->isAjaxRequest) {
            if (!empty($_POST['email'])) {
                $title = Util::t('findPassword');
                $password_email_time = date('Y-m-d H:i:s');
                $password_email_auth = Util::generateString(6);
                $member = Member::model()->find('email=:email', array(':email' => trim($_POST['email'])));
                $res = Member::model()->updateAll(array('passwd_email_time' => $password_email_time, 'passwd_email_auth' => $password_email_auth), 'email=:email', array(':email' => trim($_POST['email'])));
                $key = md5($member['name'] . $member['password'] . $member['email'] . $password_email_time . $password_email_auth);
                $changePwdUrl = Yii::app()->request->hostInfo . Yii::app()->request->baseUrl . "/site/findPasswordEdit/id/{$member['mid']}/key/{$key}";
                $mid = $member->mid;
                $companyName = Yii::app()->db->createCommand("SELECT s.company FROM shop s JOIN member m ON s.name = m.name WHERE m.mid = $mid")->queryScalar();
                $mail = Mailer::sent($member['email'], Mailer::prepareSubject('changePwd'), $this->renderPartial('/emailTemplates/changePwd', compact('companyName', 'changePwdUrl'), true));
                if ($res && $mail) {
                    $msg = Yii::t('Site', 'emailAlreadySend');
                } else {
                    $msg = Util::t('dbOperateError');
                }
                echo CJSON::encode(compact('title', 'msg'));
            }
        } else {
            $this->render('findPassword');
        }
    }

    public function actionVerifyEmail() {
        if (isset($_POST['email']) && $_POST['email']) {
            $member = Member::model()->find('email=:email', array(':email' => trim($_POST['email'])));
            if (!$member) {
                echo json_encode(array('flag' => 2, 'msg' => Util::t('emailNotReg')));
                die();
            } else {
                echo json_encode(array('flag' => 5, 'msg' => ''));
                die();
            }
        } else {
            echo json_encode(array('flag' => 1, 'msg' => Util::t('emailIsNull')));
            die();
        }
    }

    public function actionFindPasswordEdit() {
        $key = isset($_REQUEST['key']) && $_REQUEST['key'] ? $_REQUEST['key'] : '';
        $id = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : 0;
        $password = isset($_REQUEST['password']) && $_REQUEST['password'] ? $_REQUEST['password'] : 0;
        $title = Util::t('passwordEdit');
        if ($password) {
            if ($key && $id) {
                $member = Member::model()->find('mid=:mid', array(':mid' => $id));
                $key_db = md5($member['name'] . $member['password'] . $member['email'] . $member['passwd_email_time'] . $member['passwd_email_auth']);
                if (time() - strtotime($member['passwd_email_time']) > Yii::app()->params->emailUrlEffectTime * 60) {//30分钟失效
                    $msg = Util::t('overtimeLink');
                    $this->render('commomRes', compact('msg', 'title'));
                    die();
                }
                if ($key_db == $key) {
                    if ($password) {
                        if (strlen($password) < 6 || strlen($password) > 20) {
                            $msg = Util::t('passwordLength');
                            $this->render('commomRes', compact('msg', 'title'));
                            exit();
                        }
                        $res = Member::model()->updateAll(array('password' => Member::hashPassword($password)), 'mid=:mid', array(':mid' => $id));
                        if ($res) {
                            $msg = Util::t('changeSuccess');
                            $this->render('commomRes', compact('msg', 'title'));
                            exit();
                        } else {
                            $msg = Util::t('dbOperateError');
                            $this->render('commomRes', compact('msg', 'title'));
                            exit();
                        }
                    }
                } else {
                    $msg = Util::t('noEffectLink');
                    $this->render('commomRes', compact('msg', 'title'));
                    exit();
                }
            } else {
                $msg = Util::t('dataFormatError');
                $this->render('commomRes', compact('msg', 'title'));
                exit();
            }
        }
        $this->render('findPasswordEdit', compact('id', 'key'));
    }

    public function actionError() {
        if (Yii::app()->errorHandler->error) {
            $error = Yii::app()->errorHandler->error;
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionLogin() {
        $model = new LoginForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                $url = $this->createUrl(Yii::app()->user->returnUrl);
                if ($url)
                    $this->redirect($this->createUrl(Yii::app()->user->returnUrl));
                else
                    $this->redirect($this->createUrl("/stat/index"));
            }
        }

        $this->render('login', array('model' => $model));
    }

    public function actionAjaxLogin() {
        $model = new LoginForm;
        $username = isset($_REQUEST['username']) && $_REQUEST['username'] ? $_REQUEST['username'] : '';
        $password = isset($_REQUEST['password']) && $_REQUEST['password'] ? $_REQUEST['password'] : '';
        $rememberMe = isset($_REQUEST['rememberMe']) && $_REQUEST['rememberMe'] ? 1 : 0;
        $checkNum = isset($_REQUEST['checkNum']) && $_REQUEST['checkNum'] ? 1 : 0;
        if ($username && $password) {
            $model->attributes = compact('password', 'rememberMe', 'username', 'checkNum');
            if ($model->validate() && $model->login()) {//登陆成功
                echo json_encode(array('flag' => 1, 'msg' => Util::t('loginSuccess'), 'memberExpireTime' => $_SESSION['memberExpireTime'], 'memberType' => $_SESSION['memberType']));
            } else {//已经注册 未认证状态
                $password = Member::hashPassword($password);
                $member = Member::model()->find('name=:name', array(':name' => $username));
                if ($member) {
                    $msg = Util::t('usernameOrPasswordError');
                    if ($model->getError('username'))
                        $msg = $model->getError('username');
                    echo json_encode(array('flag' => 0, 'msg' => $msg, 'memberType' => 1, 'checkNum' => $model->checkNum));
                } else {
                    $memberRegister = MemberRegister::model()->find('name=:name and password=:password', array(':name' => $username, ':password' => $password));
                    if ($memberRegister) {
                        echo json_encode(array('flag' => 0, 'msg' => "<a href='" . Yii::app()->request->baseUrl . "/site/loginEmailValidate?name={$username}&password={$password}' target='_blank'>" . Util::t('emailNotValidate') . "</a>", 'memberType' => 1));
                    } else {
                        echo json_encode(array('flag' => 0, 'msg' => Util::t('usernameOrPasswordError'), 'memberType' => 1));
                    }
                }
            }
        } else {
            echo json_encode(array('flag' => 0, 'msg' => Util::t('usernameOrPasswordError'), 'memberType' => 1));
        }
        exit();
    }

    /**
     * 登陆时邮箱未验证  去验证
     * Enter description here ...
     */
    public function actionLoginEmailValidate() {
        $title = Util::t('regEmailValidate');
        $name = isset($_REQUEST['name']) && $_REQUEST['name'] ? $_REQUEST['name'] : '';
        $password = isset($_REQUEST['password']) && $_REQUEST['password'] ? $_REQUEST['password'] : '';
        if ($name && $password) {
            $member = Member::model()->find('name=:name and password=:password', array(':name' => $name, ':password' => $password));
            $memberRegister = MemberRegister::model()->find('name=:name and password=:password order by email_time desc', array(':name' => $name, ':password' => $password));
            if (strtotime($memberRegister['email_time']) + 30 * 60 > time()) {
                $msg = Util::t('reSend30min');
                $this->render('commomRes', compact('msg', 'title'));
            } else {
                if ($memberRegister && !$member) {
                    $email_time = date('Y-m-d H:i:s');
                    $generateString = Util::generateString(6);
                    $memberRegister->email_time = $email_time;
                    $memberRegister->email_auth = $generateString;
                    $res = $memberRegister->save(false);
                    
                    $key = md5($memberRegister['name'] . $memberRegister['password'] . $memberRegister['email'] . $email_time . $generateString);
                    $activateUrl = Yii::app()->request->hostInfo . "/site/registerVerify/id/{$memberRegister['mid']}/key/{$key}";
                    $shopName = $memberRegister->name;
                    $companyName = Yii::app()->db->createCommand("SELECT company FROM shop WHERE name = '$shopName' LIMIT 1")->queryScalar();
                    $mail = Mailer::sent($memberRegister['email'], Mailer::prepareSubject('register'), $this->renderPartial('/emailTemplates/register', compact('companyName', 'activateUrl'), true));
                    
                    if ($res && $mail) {
                        $msg = Yii::t('Site', 'emailAlreadySend') . $memberRegister['email'];
                        $this->render('commomRes', compact('msg', 'title'));
                    } else {
                        $msg = Util::t('dbOperateError');
                        $this->render('commomRes', compact('msg', 'title'));
                    }
                } else {
                    $msg = Util::t('dataFormatError');
                    $this->render('commomRes', compact('msg', 'title'));
                }
            }
        } else {
            $msg = Util::t('dataFormatError');
            $this->render('commomRes', compact('msg', 'title'));
        }
    }

    public function actionLogout() {
        if (!empty(Yii::app()->user->id)) {
            $member = Member::model()->findByPk(Yii::app()->user->id);
            $sessionID = Yii::app()->session->sessionID;
            $member->sessions = preg_replace("/$sessionID,?/i", "", $member->sessions);
            $member->sessions = preg_replace("/,$/i", "", $member->sessions);
            $member->save(false);
        }
        Yii::app()->user->logout();
        $this->redirect("/site/index");
    }

}