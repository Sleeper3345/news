<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m220720_152709_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique()->comment('Имя пользователя'),
            'auth_key' => $this->string(32)->comment('Токен'),
            'password_hash' => $this->string()->notNull()->comment('Пароль в hash'),
            'created_at' => $this->integer()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->notNull()->comment('Дата обновления'),
        ]);

        $this->addCommentOnTable('{{%user}}', 'Пользователи');

        // Создадим единственного пользователя - суперадмина
        $this->insert('{{%user}}', [
            'username' => 'superadmin',
            'password_hash' => Yii::$app->security->generatePasswordHash('s56jap12xc67'),
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
