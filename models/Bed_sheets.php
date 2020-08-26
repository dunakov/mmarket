<?php
/**
 * Created by PhpStorm.
 * User: uit09
 * Date: 18.10.2019
 * Time: 11:13
 */

namespace app\models;


use yii\db\ActiveRecord;
use Yii;

class Bed_sheets extends ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('blakit');
    }
    public static function tableName()
    {
        return 'bed_sheets';
    }
    public function getModelName()
    {
        return __CLASS__;
    }
}