<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "verify".
 *
 * @property integer $id
 * @property string $mobile
 * @property string $code
 * @property string $created
 * @property string $modified
 */
class Verify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'verify';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'modified'], 'safe'],
            [['mobile'], 'string', 'max' => 11],
            [['code'], 'string', 'max' => 4],
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
            'mobile' => 'Mobile',
            'code' => 'Code',
            'created' => 'Created',
            'modified' => 'Modified',
        ];
    }
}
