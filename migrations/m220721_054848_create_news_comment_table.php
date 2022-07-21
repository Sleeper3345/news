<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news_comment}}`.
 */
class m220721_054848_create_news_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news_comment}}', [
            'id' => $this->primaryKey(),
            'comment' => $this->text()->notNull()->comment('Текст комментария'),
            'news_id' => $this->integer()->notNull()->comment('ID новости'),
            'user_id' => $this->integer()->notNull()->comment('ID пользователя'),
            'created_at' => $this->integer()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->notNull()->comment('Дата обновления'),
        ]);

        $this->addCommentOnTable('{{%news_comment}}', 'Комментарии к новостям');

        $this->addForeignKey('fk_news_comment_news_id_news_id', '{{%news_comment}}', 'news_id', '{{%news}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_news_comment_user_id_user_id', '{{%news_comment}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');

        // Добавим два комментария к новости
        $comments = [
            [
                'Лето закончилось...',
                1,
                1,
                time(),
                time(),
            ],
            [
                'Ждем следующега лета...',
                1,
                1,
                time(),
                time(),
            ],
        ];

        $this->batchInsert('{{%news_comment}}', [
            'comment',
            'news_id',
            'user_id',
            'created_at',
            'updated_at',
        ], $comments);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news_comment}}');
    }
}
