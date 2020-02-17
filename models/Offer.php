<?php

namespace app\models;

use Yii;
use app\models\api\Order;

/**
 * This is the model class for table "offer".
 *
 * @property int $id
 * @property int $order_id Id заказа
 * @property int $user_id Id исполнителя
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Order $order
 * @property User $user
 */
class Offer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id'], 'required'],
            [['order_id', 'user_id'], 'integer'],
            [['created_at', 'updated_at'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Возвращает человеко понятный статус
     *
     * @return mixed
     */
    public function getStatusName()
    {
        $arr = [Order::STATUS_OPEN => 'открыт', Order::STATUS_TODO => 'в работе', Order::STATUS_DONE => 'закрыт'];
        return $arr[$this->status];
    }
}
