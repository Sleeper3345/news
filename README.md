Разворачивание проекта на Windows
------------

1. Выполнить composer install для подтягивания папки vendor
2. Развернуть проект в OpenServer:
    - Nginx
    - PHP 7.1
    - MySQL 5.7
    - Redis 3.2
3. Создать в MySQL БД с названием newsproject либо другим желаемым названием
4. В config/db-local следует указать настройки своей локальной БД
5. В config/redis-local следует указать настройки своего локального Redis
6. Выполнить rbac миграции: php yii migrate --migrationPath=@yii/rbac/migrations
7. Выполнить остальные миграции: php yii migrate