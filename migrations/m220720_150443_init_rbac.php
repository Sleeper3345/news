<?php

use yii\db\Migration;
use yii\rbac\ManagerInterface;

/**
 * Class m220720_150443_init_rbac
 */
class m220720_150443_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /** @var ManagerInterface $auth */
        $auth = Yii::$app->authManager;

        // Добавляем роль superadmin, которая будет иметь доступ ко всем разделам
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        // Задаем пользователю с id = 1 роль суперадмина
        $auth->assign($admin, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}
