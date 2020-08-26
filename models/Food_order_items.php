<?php

namespace app\models;

use Yii;


class Food_order_items extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function getDb()
    {
        return Yii::$app->get('food');
    }
    public static function tableName()
    {
        return 'food_order_items';
    }

    /**
     * {@inheritdoc}
     */

    public function getOrders(){
        return $this->hasOne(Food_orders::className(), ['id' => 'order_id']);
    }
}
