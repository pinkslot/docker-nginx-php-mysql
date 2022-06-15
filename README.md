# Тестовое задание

Простой RestApi проект на PHP без использования фреймворка.
Полное задание https://github.com/pinkslot/docker-nginx-php-mysql/blob/master/test%20task%20PHP%20Developer%20GA.pdf

## Что реализовано

1. Аутентификация с помощью Http Basic 
2. Отображение текущих призов пользователя
3. Розыгрыш одного из двух призов: бонусные баллы или деньги
4. Ограничение на количество разыгрываемых денег
5. Покрытие unit тестами основной бизнес-логики
___

## Установка

1. Склонировать репозиторий 

```sh
git clone git@github.com:pinkslot/docker-nginx-php-mysql.git
```

2. Перейти в директорию проекта :

```sh
cd docker-nginx-php-mysql
```

3. Запустить приложение :

```sh
make docker-start
```

4. Выполнить миграции БД :

```sh
make migrate
```

6. Перейти на http://localhost:8000 для использования приложения,
авторизовавшись под одним из (`user1:pass1`, `user2:pass2`, `user3:pass3`)

7. Перейти на http://localhost:8080 для доступа к PhpMyAdmin, авторизовавшись под `dev:dev` _(Опционально)_

8. Запустить тесты _(Опционально)_
```sh
make test
```

Для более подробной информации о требованиях к системе для установки, 
а также дополнительных опциях установки см. [DOCKER_CONTAINERS_README.md](DOCKER_CONTAINERS_README.md)
