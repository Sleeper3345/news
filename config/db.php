<?php

return array_merge([
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;port=3306;dbname=newsproject',
    'username' => 'admin',
    'password' => 'admin',
    'charset' => 'utf8',
],  include(__DIR__ . '/db-local.php'));
