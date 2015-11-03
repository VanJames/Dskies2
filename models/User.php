<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $password
 * @property string $given_name
 * @property string $family_name
 * @property string $specialization
 * @property integer $portfolio
 * @property string $email
 * @property string $mobile
 * @property integer $is_verified
 * @property string $avatar
 * @property string $last_login
 * @property integer $login_times
 * @property string $created
 * @property string $modified
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['portfolio', 'is_verified', 'login_times'], 'integer'],
            [['last_login', 'created', 'modified'], 'safe'],
            [['password', 'avatar'], 'string', 'max' => 255],
            [['given_name', 'family_name', 'specialization', 'email'], 'string', 'max' => 64],
            [['mobile'], 'string', 'max' => 11],
            [['email'], 'unique'],
            [['mobile'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'password' => 'Password',
            'given_name' => 'Given Name',
            'family_name' => 'Family Name',
            'specialization' => 'Specialization',
            'portfolio' => 'Portfolio',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'is_verified' => 'Is Verified',
            'avatar' => 'Avatar',
            'last_login' => 'Last Login',
            'login_times' => 'Login Times',
            'created' => 'Created',
            'modified' => 'Modified',
        ];
    }
}
