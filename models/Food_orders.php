<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id id заказа
 * @property int $user_id id заказавшего
 * @property string $time_order Время заказа
 * @property int $status Статус заказа
 * @property int $sum Сумма заказа
 */
class Food_orders extends \yii\db\ActiveRecord
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
        return 'food_orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [['time_order'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'time_order' => 'Time Order',
            'sum' => 'Сумма заказа',
            'status' => 'Status',
        ];
    }
    public function getOrderItems()
    {
        return $this->hasMany(Food_order_items::className(), ['order_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
