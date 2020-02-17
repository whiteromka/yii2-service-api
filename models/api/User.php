<?php

namespace app\models\api;

class User extends \app\models\User
{
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password_hash']);
        unset($fields['password_reset_token']);
        unset($fields['auth_key']);
        $fields[] = 'status';
        return $fields;
    }
}