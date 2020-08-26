<?php

namespace app\models;

use Yii;


class TUSER extends \yii\db\ActiveRecord
{

    public static function getDb()
    {
        return Yii::$app->get('oracle');
    }

    public static function tableName()
    {
        return 'TUSER';
    }
}
