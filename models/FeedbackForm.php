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
class FeedbackForm extends ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('food');
    }
    public static function tableName()
    {
        return 'feedback';
    }
    public function rules()
    {
        return [
            [['user_id','status'], 'integer'],
            [['text'], 'string', 'min' => 10],
            [['name'], 'string', 'max' => 120],
            [['text'], 'required'],
            [['tel'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 200],

        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => '№',
            'text' => 'Текст',
            'name' => 'Пользователь',
            'user_id' => 'Пользователь',
            'email' => 'Электронная почта',
            'tel' => 'Телефон',
            'status' => 'Статус'

        ];
    }

}