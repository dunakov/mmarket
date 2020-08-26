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
class Food_categories extends ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('food');
    }
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 200],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => '№',
            'name' => 'Название',
        ];
    }
    public static function tableName()
    {
        return 'food_categories';
    }

    public function getProducts()
    {
        return $this->hasMany(Food_products::className(), ['category_id' => 'id']);
    }
}