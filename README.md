Разворачивание проекта на Windows
------------

1. Выполнить composer install для подтягивания папки vendor
2. Развернуть проект в OpenServer:
    - Nginx
    - PHP 7.4
    - MySQL
3. Создать в MySQL БД с названием newsproject либо другим желаемым названием
4. Выполнить rbac миграции: php yii migrate --migrationPath=@yii/rbac/migrations