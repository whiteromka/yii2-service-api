<?php

namespace app\models\api;

use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use Yii;

class Offer extends \app\models\Offer
{
    /**
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();
        Arrayhelper::remove($fields,'user_id');
        $fields['status_code'] = 'status';
        $fields['status'] = 'statusName';
        $fields['creator_offer'] = 'user';
        $fields[] = 'order';
        return $fields;
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
     * Создает заявку
     *
     * @param int $order_id
     * @param int $user_id
     * @return Offer|array
     */
    public static function create(int $order_id, int $user_id)
    {
        $order = Order::find()
            ->where(['AND', ['status' => Order::STATUS_OPEN], ['id' => $order_id]])
            ->andWhere('creator_id != :creator_id', ['creator_id' => $user_id])
            ->one();

        if (!$order) {
            return ['error' => 'order not found'];
        }

        $offer = new Offer();
        $offer->order_id = $order_id;
        $offer->user_id = $user_id;
        $offer->save(false);
        return $offer;
    }

    /**
     * Отмена заявки (удаление)
     *
     * @param int $offer_id - id заявки
     * @param int $user_id - id пользователя создавшего заявку
     * @return false|int
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public static function cancel(int $offer_id, int $user_id)
    {
        /** @var Offer $offer */
        $offer = self::find()->with('order')
            ->where(['id' => $offer_id, 'user_id'=> $user_id])
            ->one();
        if (!$offer) {
            return ['error' => 'offer not found'];
        }

        $statusOrder = $offer->order->status;
        if ($statusOrder != Order::STATUS_DONE) {
            return $offer->delete();
        }
        return ['error'=>'something wrong...'];
    }

    /**
     * Подтверждение статуса для заявки и заказа
     *
     * @param int $offer_id
     * @param int $user_id
     * @return Offer
     */
    public static function confirm(int $offer_id, int $user_id)
    {
        /** @var Offer $offer */
        $offer =  self::find()->where(['id' => $offer_id])->one();
        if (!$offer) {
            return ['error' => 'offer not found'];
        }
        /** @var Order $order */
        $order = $offer->order;

        if ($order->creator_id == $user_id) {
            $order->status = Order::STATUS_TODO;
            $order->save(false);
            $offer->status = Order::STATUS_TODO;
            $offer->save(false);

            return $offer;
        }
        return ['error' => 'u cant confirm offer for not own order'];
    }

    /**
     * Подтверждение статуса для заявки и заказа
     *
     * @param int $offer_id
     * @param int $user_id
     * @return Offer
     */
    public static function done(int $offer_id, int $user_id)
    {
        /** @var Offer $offer */
        $offer =  self::find()->where(['id' => $offer_id, 'user_id' => $user_id])->one();
        if (!$offer) {
            return ['error' => 'offer not found'];
        }
        /** @var Order $order */
        $order = $offer->order;

        $order->status = Order::STATUS_DONE;
        $order->save(false);
        $offer->status = Order::STATUS_DONE;
        $offer->save(false);
        return $offer;
    }
}