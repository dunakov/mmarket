<?php

namespace app\models;

use Yii;


class Food_credit extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('oracle');
    }
    public static function tableName()
    {
        return 'FOOD_CREDIT_USED';
    }

}
