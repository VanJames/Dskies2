<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auction".
 *
 * @property integer $id
 * @property string $start_time
 * @property string $end_time
 * @property integer $type
 * @property integer $week
 * @property string $lease_start
 * @property string $lease_end
 * @property integer $seats
 * @property string $created
 * @property string $modified
 */
class Auction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_time', 'end_time', 'lease_start', 'lease_end', 'created', 'modified'], 'safe'],
            [['type', 'week', 'seats'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'type' => 'Type',
            'week' => 'Week',
            'lease_start' => 'Lease Start',
            'lease_end' => 'Lease End',
            'seats' => 'Seats',
            'created' => 'Created',
            'modified' => 'Modified',
        ];
    }
}
