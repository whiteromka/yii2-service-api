<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $title              - название заказа
 * @property string|null $descr         - описание заказа
 * @property int|null $reward           - вознаграждение в руб
 * @property string|null $deadline      - крайний срок
 * @property int|null $percent_agent    - % посредника
 * @property int|null $status           - статус
 * @property int|null $creator_id       - id создателя заказа
 * @property string $created_at         - дата создания
 * @property string $updated_at         - дата редактированя
 *
 * @property Offer[] $offers            - связь с заявками
 * @property User $creator              - связь с пользователями
 * @property Review[] $reviews          - связь с отзывами
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_OPEN = 0; // статус открыт
    const STATUS_TODO = 1; // статус в работе
    const STATUS_DONE = 2; // статус выполнен

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','reward', 'descr', 'creator_id'], 'required'],
            [['reward', 'percent_agent', 'status', 'creator_id'], 'integer'],
            ['status', 'default', 'value'=>0],
            [['title', 'deadline', 'created_at', 'updated_at'], 'string', 'max' => 255],
            [['descr'], 'string', 'max' => 1000],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['creator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'descr' => 'Descr',
            'reward' => 'Reward',
            'deadline' => 'Deadline',
            'percent_agent' => 'Percent Agent',
            'status' => 'Status',
            'creator_id' => 'Creator ID',
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
        return $this->hasMany(Offer::class, ['order_id' => 'id']);
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

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['offer_id' => 'id']);
    }

    /**
     * Возвращает человеко понятный статус
     *
     * @return mixed
     */
    public function getStatusName()
    {
        $arr = [self::STATUS_OPEN => 'открыт', self::STATUS_TODO => 'в работе', self::STATUS_DONE => 'закрыт'];
        return $arr[$this->status];
    }
}
