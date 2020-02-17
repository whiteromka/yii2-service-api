<?php

use yii\db\Migration;

/**
 * Class m200209_171624_crete_order_table
 */
class m200209_171624_crete_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'descr' => $this->string(1000)->comment('описание заказа'),
            'reward' => $this->integer(),
            'deadline' => $this->string(),
            'percent_agent' => $this->tinyInteger(),
            'status' => $this->tinyInteger(),
            'creator_id' => $this->integer()->comment('Id создателя заказа'),
            //'executor_id' => $this->integer(),

            'created_at' => $this->string()->notNull()->defaultValue(date('d-m-Y H:i:s')),
            'updated_at' => $this->string()->notNull()->defaultValue(date('d-m-Y H:i:s'))
        ]);

        $this->addForeignKey(
            'fkey-order_creator_id-user_id',
            'order',
            'creator_id',
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
        $this->dropTable('{{%order}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200209_171624_crete_order_table cannot be reverted.\n";

        return false;
    }
    */
}
