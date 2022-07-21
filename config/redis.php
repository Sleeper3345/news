<?php

return array_merge([
    'class' => 'yii\redis\Connection',
    'hostname' => 'localhost',
    'port' => 6379,
    'database' => 0,
],  include(__DIR__ . '/redis-local.php'));
