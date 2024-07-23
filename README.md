# Тестовое задание

## Требования
- Symfony 6 или 7
- Doctrine ORM
- Без нативных запросов SQL
- MySQL
- Документация по установке и запуску (можно в readme.md)

## Спецификация
Сущности:
- Книга (наименование, год издания, издатель (MtO), автор(MtM))
- Автор (имя, фамилия, книги (MtM))
- Издатель (наименование, адрес, книги (OtM))

HTTP API (пользовательские интерфейсы не нужны):
- Получение всех книг (помимо полей книги, возвращать фамилию автора и наименование издательства)
- Создание нового автора
- Создание книги с привязкой к существующему автору
- Редактирование издателя
- Удаление книги/автора/издателя

Symfony команды:
- Команда по наполнению БД тестовыми данными (несколько авторов/книг/издательств)
- Команда по удалению всех авторов, у которых нет книг

# Установка

## Скопировать .env файл

```sh
cp .env.dist .env
```

## Запустить контейнеры

```sh
docker compose up -d --build
```

## Запустить миграции

```sh
docker exec -it book_app php bin/console --no-interaction doctrine:migrations:migrate
```

## Заполнение БД тестовыми данными

```sh
docker exec -it book_app php bin/console --no-interaction doctrine:fixtures:load
```

## Запустить сервер

```sh
docker exec -it book_app symfony server:start --no-tls
```

## Запросы к API

[Документация API Swagger](http://localhost/api)

### Получение всех книг (помимо полей книги, возвращать фамилию автора и наименование издательства)

```sh
curl -X 'GET' \
'http://localhost/api/books' \
-H 'accept: application/json'
```

### Создание нового автора

```sh
curl -X 'POST' \
  'http://localhost/api/authors' \
  -H 'accept: application/json' \
  -H 'Content-Type: application/json' \
  -d '{
  "firstname": "Борис",
  "lastname": "Акунин"
}'
```

### Создание книги с привязкой к существующему автору

**Примечание**: так как в ТЗ связь книги и автора задана как Many-to-Many, возможна привязка нескольких авторов к 
одной книге

```sh
curl -X 'POST' \
  'http://localhost/api/books' \
  -H 'accept: application/json' \
  -H 'Content-Type: application/json' \
  -d '{
  "name": "Поэма об осени",
  "year": 2024,
  "publisher": "api/publishers/1",
  "authors": [
    "api/authors/1",
    "api/authors/2"
  ]
}'
```

### Редактирование издателя

```sh
curl -X 'PATCH' \
  'http://localhost/api/publishers/2' \
  -H 'accept: application/json' \
  -H 'Content-Type: application/json' \
  -d '{
  "address": "Санкт-Петербург, Литейный пр., 47"
}'
```

### Удаление книги

```sh
curl -X 'DELETE' \
  'http://localhost/api/books/4' \
  -H 'accept: */*'
```

### Удаление автора

```sh
curl -X 'DELETE' \
  'http://localhost/api/authors/4' \
  -H 'accept: */*'
```

### Удаление издателя

```sh
curl -X 'DELETE' \
  'http://localhost/api/publishers/3' \
  -H 'accept: */*'
```

### Команда по наполнению БД тестовыми данными (несколько авторов/книг/издательств)

```sh
docker exec -it book_app php bin/console --no-interaction doctrine:fixtures:load
```

### Команда по удалению всех авторов, у которых нет книг

```sh
docker exec -it book_app php bin/console app:delete-authors
```

## Остановить контейнеры

```sh
docker compose down
```
