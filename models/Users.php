<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $fio ФИО Сотрудника
 * @property string $login Логин
 * @property string $password пароль
 * @property string $auth_key ключ авторизации
 * @property string $limit_sum Лимит
 * @property string $role Роль
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */

    const ROLE_USER = 1;
    const ROLE_TD = 2;
    const ROLE_CANTEEN = 3;
    const ROLE_ADMIN = 10;

    public static function getDb()
    {
        return Yii::$app->get('blakit');
    }
    public static function tableName()
    {
        return 'users';
    }

    public static function roles()
    {
        return [
            self::ROLE_USER => Yii::t('app', 'User'),
            self::ROLE_TD => Yii::t('app', 'Td'),
            self::ROLE_CANTEEN => Yii::t('app', 'Canteen'),
            self::ROLE_ADMIN => Yii::t('app', 'Admin'),
        ];
    }


    public function getRoleName(int $id)
    {
        $list = self::roles();
        return $list[$id] ?? null;
    }
    public function isTd()
    {
        return ($this->role == self::ROLE_TD);
    }
    public function isCanteen()
    {
        return ($this->role == self::ROLE_CANTEEN);
    }

    public function isAdmin()
    {
        return ($this->role == self::ROLE_ADMIN);
    }


    public function isUser()
    {
        return ($this->role == self::ROLE_USER);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio'], 'string'],
            [['login', 'password'], 'string', 'max' => 120],
            [['limit_sum'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
            'login' => 'Логин',
            'password' => 'Пароль',
            'auth_key' => 'Auth Key',
            'limit_sum' => 'Лимит',
            'role' => 'роль'
        ];
    }
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {

    }
    public static function findByUsername($username)
    {
        return static::findOne(['login'=>$username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {

        //return \Yii::$app->security->validatePassword($password, $this->password);
        return $this->password === $password;

    }

    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['user_id' => 'id']);
    }
}
