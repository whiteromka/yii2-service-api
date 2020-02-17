<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username                        - имя
 * @property string $auth_key                        -
 * @property string $password_hash                   - хэш пароля
 * @property string|null $password_reset_token       -
 * @property string $email                           - email
 * @property string|null $phone                      - телефон
 * @property int|null $person_or_organization        - 1=ф.л. 2=юр.л.
 * @property string $created_at                      -
 * @property string $updated_at                      -
 *
 * @property Offer[] $offers                         - связь с пользоват
 * @property Order[] $orders                         - связь с заказами
 * @property Review[] $reviews                       - связь с отзывами
 */

class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const PERSON = 1;
    const ORGANIZATION = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'email'], 'required'],
            [['person_or_organization'], 'integer'],
            [['person_or_organization'], 'default', 'value'=> self::PERSON],
            [['username', 'password_hash', 'password_reset_token', 'email', 'phone', 'created_at', 'updated_at'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'phone' => 'Phone',
            'person_or_organization' => 'Person Or Organization',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Offers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOffers()
    {
        return $this->hasMany(Offer::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['creator_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['user_id' => 'id']);
    }

    /**
     * Возвращает физ.\юр. лицо
     *
     * @return mixed
     */
    public function getStatus()
    {
        $arr = [self::PERSON => 'физ.л.', self::ORGANIZATION => 'юр.л.'];
        return $arr[$this->person_or_organization];
    }

    /**
     * Устанавливаем пароль
     *
     * @param $password
     * @throws Exception
     */
    public function setPassword($password)
    {
        $passwordHash = Yii::$app->security->generatePasswordHash($password);
        $this->password_hash = $passwordHash;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function setAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }


    public function getId()
    {
        return $this->id;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {}

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function findByEmail($email)
    {
        return self::findOne(['email'=>$email]);
    }

    /** Сравнивает переданный пароль с хэшем из БД
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        try{
            $result = Yii::$app->security->validatePassword($password, $this->password_hash);
        } catch(\Exception $e) {
            return false;
        }
        return $result;
    }
}
