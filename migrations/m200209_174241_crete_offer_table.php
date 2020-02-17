<?php

use yii\db\Migration;

/**
 * Class m200209_174241_crete_offer_table
 */
class m200209_174241_crete_offer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%offer}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull()->comment('Id заказа'),
            'user_id' => $this->integer()->notNull()->comment('Id исполнителя'),
            'status' => $this->tinyInteger(),

            'created_at' => $this->string()->notNull()->defaultValue(date('d-m-Y H:i:s')),
            'updated_at' => $this->string()->notNull()->defaultValue(date('d-m-Y H:i:s'))
        ]);

        $this->addForeignKey(
            'fkey-offer_order_id-user_id',
            'offer',
            'order_id',
            'order',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fkey-offer_user_id-user_id',
            'offer',
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
        $this->dropTable('{{%offer}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200209_174241_crete_offer_table cannot be reverted.\n";

        return false;
    }
    */
}
