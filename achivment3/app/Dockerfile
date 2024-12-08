# Используем базовый образ
FROM php:7.4-apache
# Копируем файлы проекта в рабочую директорию
COPY . /var/www/html
# Устанавливаем зависимости
RUN docker-php-ext-install pdo pdo_mysql
# Указываем порт, на котором будет работать приложение
EXPOSE 80
#сборка
#docker build -t miemhomeworkrestachivment2:1.0 .
