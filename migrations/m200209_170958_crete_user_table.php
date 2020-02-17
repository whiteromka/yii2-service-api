<?php

use yii\db\Migration;

/**
 * Class m200209_170958_crete_user_table
 */
class m200209_170958_crete_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'phone' => $this->string(),
            'person_or_organization' => $this->tinyInteger()->defaultValue(1),

            'created_at' => $this->string()->notNull()->defaultValue(date('d-m-Y H:i:s')),
            'updated_at' => $this->string()->notNull()->defaultValue(date('d-m-Y H:i:s'))
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200209_170958_crete_user_table cannot be reverted.\n";

        return false;
    }
    */
}
