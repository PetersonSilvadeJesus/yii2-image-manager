<?php

use yii\db\Migration;

/**
 * Handles the creation for table `image_manager`.
 */
class m160622_085710_create_image_manager_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
		//image_manager: create table
        $this->createTable('{{%image_manager}}', [
            'id' => $this->primaryKey(),
			'fileName' => $this->string(128)->notNull(),
			'fileHash' => $this->string(32)->notNull(),
			'created' => $this->datetime()->notNull(),
			'modified' => $this->datetime(),
        ]);
		
		//image_manager: alter id column
        if ($this->db->driverName === 'mysql') {
            $this->alterColumn('{{%image_manager}}', 'id', 'INT(10) UNSIGNED NOT NULL AUTO_INCREMENT');
        }

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%image_manager}}');
    }
}
