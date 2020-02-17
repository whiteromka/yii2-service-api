<?php

namespace app\controllers\api;

use app\models\api\Order;
use app\models\api\Offer;
use Yii;
use yii\db\StaleObjectException;

class OfferController extends BaseController
{
    public $modelClass = Offer::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    /**
     * Экшен добавления заявки
     *
     * @return Order|array
     */
    public function actionCreate()
    {
        list($request, $user_id) = $this->data();
        $order_id = $request->post('order_id');
        if (!$order_id) {
            return ['error' => 'need param order_id'];
        }

        if ($request->isPost) {
           return Offer::create($order_id, $user_id);
        }
    }

    /**
     * Отмена заявки
     *
     * @return array|false|int
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionCancel()
    {
        list($request, $user_id) = $this->data();
        $id = $request->post('id');
        if (!$id) {
            return ['error' => 'need param id'];
        }

        return Offer::cancel($id, $user_id);
    }

    /**
     * Экшен подтвердить заявку (вызывает создатель заказа)
     *
     * @return Offer|array
     */
    public function actionConfirm()
    {
        list($request, $user_id) = $this->data();
        $offer_id = $request->post('offer_id');
        if (!$offer_id) {
            return ['error' => 'need param offer_id'];
        }

        return Offer::confirm($offer_id, $user_id);
    }

    /**
     * Экшен завершить заявку и зказ (вызывает исполнитель)
     *
     * @return Offer|array
     */
    public function actionDone()
    {
        list($request, $user_id) = $this->data();
        $offer_id = $request->post('offer_id');
        if (!$offer_id) {
            return ['error' => 'need param offer_id'];
        }

        return Offer::done($offer_id, $user_id);
    }
}