<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m220720_175058_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique()->notNull()->comment('Название'),
            'parent_id' => $this->integer()->comment('ID родительской категории'),
            'created_at' => $this->integer()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->notNull()->comment('Дата обновления'),
        ]);

        $this->addCommentOnTable('{{%user}}', 'Категории');

        $this->addForeignKey('fk_category_parent_id_category_id', '{{%category}}', 'parent_id', '{{%category}}', 'id', 'cascade', 'cascade');

        // Создадим одну категорию
        $this->insert('{{%category}}', [
            'name' => 'Страны',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        // И создадим связанную с ней категорию
        $this->insert('{{%category}}', [
            'name' => 'Россия',
            'parent_id' => $this->db->getLastInsertID(),
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
