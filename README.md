# php-mvc-template

From the project root folder, execute :
```shell
composer install
```

Create a ``.env`` file and copy-paste the content from `.env.example`, and fill.

Run the file ``migrate.php`` to apply necessary migrations.
```shell
php migrate.php
```
Run the start command in the ``/public`` folder.
```shell
cd ./public
php -S localhost:8000
```
