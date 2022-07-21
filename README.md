Разворачивание проекта на Windows
------------

1. Выполнить composer install для подтягивания папки vendor
2. Развернуть проект в OpenServer:
    - Nginx
    - PHP 7.1
    - MySQL 5.7
    - Redis 3.2
3. Создать в MySQL БД с названием newsproject либо другим желаемым названием
4. Создать файл config/db-local.php и в нем следует указать настройки своей локальной БД (по аналогии с db.php)
5. Создать файл config/redis-local.php и в нем следует указать настройки своего локального Redis (по аналогии с redis.php)
6. Выполнить rbac миграции: php yii migrate --migrationPath=@yii/rbac/migrations
7. Выполнить остальные миграции: php yii migrate