<?php

use yii\db\Migration;

class m170226_082217_create_table_images extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%images}}', [
            'id' => $this->integer(10)->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'entity_name' => $this->string(80)->notNull(),
            'entity_id' => $this->integer(10)->unsigned()->notNull(),
            'filename' => $this->string(300),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%images}}');
    }
}
