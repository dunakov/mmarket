<?php


namespace app\models;



use yii\db\ActiveRecord;

class Products_ged extends ActiveRecord
{
    public static function getDb()
    {
        return \Yii::$app->get('firebird');
    }
    public static function tableName()
    {
        return 'USR$DEL_REMAINSINFO';
    }
}