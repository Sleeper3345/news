<?php

use app\helpers\SlugHelper;
use yii\db\Migration;
use yii\db\Query;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m220721_040617_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->unique()->notNull()->comment('Заголовок для URL'),
            'title' => $this->string(200)->notNull()->comment('Заголовок'),
            'category_id' => $this->integer()->notNull()->comment('ID категории'),
            'announcement' => $this->string()->notNull()->comment('Анонс'),
            'text' => $this->text()->notNull()->comment('Подробный текст'),
            'active' => $this->boolean()->notNull()->defaultValue(true)->comment('Активность'),
            'created_at' => $this->integer()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->notNull()->comment('Дата обновления'),
        ]);

        $this->addCommentOnTable('{{%news}}', 'Новости');

        $this->addForeignKey('fk_news_category_id_category_id', '{{%news}}', 'category_id', '{{%category}}', 'id', 'no action', 'cascade');

        $category = (new Query())
            ->from('{{%category}}')
            ->select(['id'])
            ->where(['name' => 'Россия'])
            ->one();

        // Создадим несколько новостей для одной и той же категории
        $news = [
            [
                SlugHelper::generateString('Стал известен прогноз погоды на третью декаду июля в Новосибирске'),
                'Стал известен прогноз погоды на третью декаду июля в Новосибирске',
                $category['id'],
                'announcement' => 'Новосибирск, 21 июля - АиФ-Новосибирск.',
                'Третья декада июля в Новосибирске и области будет прохладной и дождливой. Об этом сообщили синоптики Западно-Сибирского гидрометцентра.',
                time(),
                time(),
            ],
            [
                SlugHelper::generateString('«Речфлот» Новосибирска отменил две остановки из-за низкого уровня воды в Оби'),
                '«Речфлот» Новосибирска отменил две остановки из-за низкого уровня воды в Оби',
                $category['id'],
                'announcement' => 'Чтобы уровень воды поднялся, необходимы ливни в Горном Алтае',
                'С 19 июля отменяются остановки «Бибиха» и «Седова Заимка» по линии «Речной вокзал» — «Седова Заимка» — «Речной вокзал» в связи с пониженным уровнем воды, — говорится на сайте «Речфлота» в Новосибирске.',
                time(),
                time(),
            ],
            [
                SlugHelper::generateString('Входную зону в новый парк у реки Ельцовка-1 в Новосибирске готовят к сдаче'),
                'Входную зону в новый парк у реки Ельцовка-1 в Новосибирске готовят к сдаче',
                $category['id'],
                'announcement' => 'Сейчас к сдаче готовится входная группа',
                'Сегодня, 19 июля, прошло выездное совещание по выполнению первой очереди благоустройства парка в пойме реки Ельцовка-1. Входная зона парка составляет почти 1 гектар.',
                time(),
                time(),
            ],
            [
                SlugHelper::generateString('Экстренное предупреждение из-за грозы 21 июля выпустили в Новосибирске'),
                'Экстренное предупреждение из-за грозы 21 июля выпустили в Новосибирске',
                $category['id'],
                'announcement' => 'Синоптики в Новосибирске распространили экстренное предупреждение из-за грозы 21 июля.',
                'Ливень с грозой ожидается в Новосибирске 21 июля. Из-за резкого ухудшения погоды синоптики сделали экстренное предупреждение. Информация размещена на сайте ФГБУ «Западно-Сибирского УГМС».',
                time(),
                time(),
            ],
        ];

        $this->batchInsert('{{%news}}', [
            'slug',
            'title',
            'category_id',
            'announcement',
            'text',
            'created_at',
            'updated_at',
        ], $news);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}
