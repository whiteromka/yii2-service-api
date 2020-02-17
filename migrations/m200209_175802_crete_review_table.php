<?php

use yii\db\Migration;

/**
 * Class m200209_175802_crete_review_table
 */
class m200209_175802_crete_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%review}}', [
            'id' => $this->primaryKey(),
            'comment' => $this->string(1000),
            'stars' => $this->tinyInteger(),
            //'order_id' => $this->integer()->notNull()->comment('Id заказа'),
            'offer_id' => $this->integer()->notNull()->comment('Id заявки'),
            'user_id' => $this->integer()->notNull()->comment('Id пользователя (испльнителя)'),

            'created_at' => $this->string()->notNull()->defaultValue(date('d-m-Y H:i:s')),
            'updated_at' => $this->string()->notNull()->defaultValue(date('d-m-Y H:i:s'))
        ]);

        $this->addForeignKey(
            'fkey-review_offer_id-user_id',
            'review',
            'offer_id',
            'order',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fkey-review_creator_id-user_id',
            'review',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%review}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200209_175802_crete_review_table cannot be reverted.\n";

        return false;
    }
    */
}
