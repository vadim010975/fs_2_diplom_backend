## инструкция для запуска бэкенда
## На сервере PHP >= 8.2, composer
## 1. Скачиваем проект из репозитария
## 2. Устанавливаем зависимости composer install
## 3. Создаем файл базы данных database/database.sqlite
## 4. Создаем файл .env
## в нем указываем переменные окружения для базы данных
## DB_CONNECTION=sqlite
## DB_DATABASE=Абсолютный путь до файла database.sqlite
## 5. Запускаем миграции php artisan migrate
## 6. Заполняем таблицу Users одним пользователем - команда php artisan db:seed
## 7. Создаем символьную ссылку php artisan storage:link
##
## Данные пользователя для авторизации:
## электронный адрес: email@mail.ru
## пароль: 12345678


## Backend ваполнен на Laravel.
## Для авторизации используется Laravel Sanctum.

