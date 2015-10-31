<?php

class Mailer {

    public static function sent($address, $subject, $body){
        #$address = 'zhang.chenxi@sh.adways.net';
        $mail = new PHPMailer();
        $mail->CharSet = "utf-8";
        $mail->Encoding = "base64";
        $mail->IsSMTP(); // telling the class to use SMTP
//        $mail->SMTPDebug = true;
//        $mail->SMTPAuth   = true;  
        $mail->Host = "114.80.77.87"; // SMTP server
//        $mail->Username = 'no-reply@nint.jp';
//        $mail->Password = 'adways';
        $mail->Port = 25;
        $mail->SetFrom('no-reply@nint.jp');
        $mail->Subject = $subject;
        Yii::trace('mail subject:'.$mail->Subject);
        $mail->MsgHTML($body);
        $mail->AddAddress($address);

        return $mail->Send();
    }
    
    public static function prepareSubject($mailType) {
        switch ($mailType) {
            case 'payRemind1':
                $subject = Yii::t('Mail', 'payRemind1');
                break;

            case 'payRemind2':
                $subject = Yii::t('Mail', 'payRemind2');
                break;

            case 'payRemind3':
                $subject = Yii::t('Mail', 'payRemind3');
                break;

            case 'orderGenerated':
                $subject = Yii::t('Mail', 'orderGenerated');
                break;

            case 'orderGenerated':
                $subject = Yii::t('Mail', 'requestGenerated');
                break;

            case 'orderEffected':
                $subject = Yii::t('Mail', 'orderEffected');
                break;
            
            case 'register':
                $subject = Yii::t('Mail', 'register');
                break;
            
            case 'changePwd':
                $subject = Yii::t('Mail', 'changePwd');
                break;

            default:
                break;
        }
        return $subject;
    }

}
