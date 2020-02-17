<?php

namespace app\controllers\api;

use app\models\api\Order;
use Yii;

class OrderController extends BaseController
{
    public $modelClass = Order::class;

    public function actions()
    {
       $actions = parent::actions();
       unset($actions['create']);
       return $actions;
    }

    /**
     * Экшен добаления заказа
     *
     * @return Order|array
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;

        $user = Yii::$app->getUser();
        $creator_id = $user->getId();

        if ($request->isPost) {
            $order = new Order();
            $order->attributes = $request->post();
            $order->creator_id = $creator_id;
            $order->status = Order::STATUS_OPEN;

            if ($order->save()) {
                return $order;
            }
            return ['error' => $order->errors];
        }
    }

}