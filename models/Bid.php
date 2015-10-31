<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bid".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $user_name
 * @property integer $auction_id
 * @property integer $offer
 * @property integer $success
 * @property string $created
 * @property string $modified
 */
class Bid extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bid';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'auction_id', 'offer', 'success'], 'integer'],
            [['created', 'modified'], 'safe'],
            [['user_name'], 'string', 'max' => 64]
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
            'user_name' => 'User Name',
            'auction_id' => 'Auction ID',
            'offer' => 'Offer',
            'success' => 'Success',
            'created' => 'Created',
            'modified' => 'Modified',
        ];
    }
}
