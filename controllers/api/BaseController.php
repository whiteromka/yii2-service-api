<?php

namespace app\controllers\api;

use app\models\api\User;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;

class BaseController extends ActiveController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function($username, $password) {
                return $this->auth($username, $password);
            }
        ];
        return $behaviors;
    }

    /** Найдет пользователя с таким логином и паролем и вернет его либо NULL
     * @param string $username
     * @param string $password
     * @return null|User
     */
    public function auth($username, $password)
    {
        if ($user = User::findOne(['username' => $username])) {
            if ($user->validatePassword($password)) {
                return $user;
            }
        }
        return null;
    }

    /**
     * Вернет Request и user_id
     *
     * @return array
     */
    protected function data()
    {
        $request = Yii::$app->request;
        $user = Yii::$app->getUser();
        $user_id = $user->getId();

        return [$request, $user_id];
    }
}