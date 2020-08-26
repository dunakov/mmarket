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
class Food_products extends ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('food');
    }
    public function rules()
    {
        return [
            [['category_id', 'weighted','qty'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['price_per_kg'], 'string', 'max' => 60],
            [['image'], 'string', 'max' => 220],
            [['description'], 'string'],
            [['min_weight', 'max_weight'], 'double'],
            [['min_price', 'max_price'], 'double'],
            [['packing_size'], 'string', 'max' => 120],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Food_categories::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => '№',
            'image' => 'Изображение',
            'category_id' => 'Категория',
            'name' => 'Наименование товара',
            'price_per_kg' => 'Цена за фасовку',
            'description' => 'Описание',
            'packing_size' => 'Размер упаковки',
            'weighted' => 'Тип товара',
            'min_price' => 'Минимальная цена',
            'max_price' => 'Максимальаня цена',
            'min_weight' => 'Минимальный вес',
            'max_weight' => 'Максимальный вес',
            'qty' => 'Количество'

        ];
    }

    public function calculatePrice()
    {
        if ($this->weighted == 1)
        {
            $this->min_price = round(($this->price_per_kg*$this->min_weight), 2, PHP_ROUND_HALF_UP);
            $this->max_price = round(($this->price_per_kg*$this->max_weight), 2, PHP_ROUND_HALF_UP);
            $this->packing_size = $this->min_weight.'-'.$this->max_weight;
        }
        else
        {
            $this->packing_size = '1 шт';
            $this->min_price = $this->price_per_kg;
            $this->max_price = $this->price_per_kg;
        }
    }

    public static function tableName()
    {
        return 'food_products';
    }

    public function getCategory()
    {
        return $this->hasOne(Food_categories::className(), ['id' => 'category_id']);
    }
}