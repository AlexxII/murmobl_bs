<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "base_stations".
 *
 * @property int $id
 * @property string $records_location
 * @property string $req_num
 * @property string $duration
 * @property string $company_title
 * @property string $res
 * @property string $placement
 * @property string $latitude
 * @property string $longitude
 * @property string $azimuth
 * @property string $frequency
 * @property string $horiz_width
 * @property string $vertic_width
 */
class BaseStations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_stations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['records_location', 'req_num', 'duration', 'company_title', 'res', 'placement', 'latitude', 'longitude', 'azimuth', 'frequency', 'horiz_width', 'vertic_width'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'records_location' => 'Records Location',
            'req_num' => 'Req Num',
            'duration' => 'Duration',
            'company_title' => 'Company Title',
            'res' => 'Res',
            'placement' => 'Placement',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'azimuth' => 'Azimuth',
            'frequency' => 'Frequency',
            'horiz_width' => 'Horiz Width',
            'vertic_width' => 'Vertic Width',
        ];
    }
}
