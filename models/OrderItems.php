<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_items".
 *
 * @property int $id
 * @property int $order_id Номер заказа
 * @property string $product_group Товарная группа
 * @property string $code Код товара
 * @property string $code_a Артикул
 * @property string $name Название товара
 * @property string $model Модель
 * @property string $fabric_number Номер ткани
 * @property string $fabric_image Номер рисунка
 * @property int $qty Количество
 * @property int $price Цена
 */
class OrderItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function getDb()
    {
        return Yii::$app->get('blakit');
    }
    public static function tableName()
    {
        return 'order_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id'], 'required'],
            [['order_id', 'qty'], 'integer'],
            [['name'], 'string'],
            [['product_group', 'barcode'], 'string', 'max' => 300],
            [['code', 'code_a'], 'string', 'max' => 60],
            [['model', 'fabric_number', 'fabric_image'], 'string', 'max' => 120],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_group' => 'Product Group',
            'code' => 'Code',
            'code_a' => 'Code A',
            'name' => 'Name',
            'model' => 'Model',
            'fabric_number' => 'Fabric Number',
            'fabric_image' => 'Fabric Image',
            'barcode' => 'barcode',
            'qty' => 'Qty',
            'price' => 'price'
        ];
    }
    public function getOrders(){
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }
}
