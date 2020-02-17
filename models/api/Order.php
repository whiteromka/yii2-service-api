<?php

namespace app\models\api;

use yii\helpers\ArrayHelper;

class Order extends \app\models\Order
{
    /**
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();
        Arrayhelper::remove($fields,'creator_id');
        $fields['status_code'] = 'status';
        $fields['status'] = 'statusName';
        $fields['creator_order'] = 'creator';
        return $fields;
    }

    /**
     * Gets query for [[Creator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }
}