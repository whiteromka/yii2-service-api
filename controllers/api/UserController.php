<?php

namespace app\controllers\api;

use app\models\api\User;
use Yii;

class UserController extends BaseController
{
    public $modelClass = User::class;

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['create']; // экшен create можно без автроизации
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    /**
     * Экшен добавления пользователя (регистрация)
     *
     * @return User|array
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            if (!$pass = $request->post('password')) {
                return ['error' => 'need param password'];
            }
            $user = new User();
            $user->attributes = $request->post();
            $user->setPassword($pass);
            $user->setAuthKey();

            if ($user->save()) {
                return $user;
            }
            return ['error' => $user->errors];
        }
    }

}