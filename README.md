# Тестовое задание

Требования
• Symfony 6 или 7
• Doctrine ORM
• Без нативных запросов SQL
• MySQL
• Документация по установке и запуску (можно в readme.md)

Спецификация
Сущности:
• Книга (наименование, год издания, издатель (MtO), автор(MtM))
• Автор (имя, фамилия, книги (MtM))
• Издатель (наименование, адрес, книги (OtM))

HTTP API (пользовательские интерфейсы не нужны):
• Получение всех книг (помимо полей книги, возвращать фамилию автора и наименование издательства)
• Создание нового автора
• Создание книги с привязкой к существующему автору
• Редактирование издателя
• Удаление книги/автора/издателя

Symfony команды:
• Команда по наполнению БД тестовыми данными (несколько авторов/книг/издательств)
• Команда по удалению всех авторов, у которых нет книг

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

[Документация API](http://localhost/api)

### Получение всех книг (помимо полей книги, возвращать фамилию автора и наименование издательства)

[Ссылка](http://localhost/api/books)

### Создание нового автора

```sh
curl -X 'POST' \
  'http://localhost/api/authors' \
  -H 'accept: application/ld+json' \
  -H 'Content-Type: application/ld+json' \
  -d '{
  "firstname": "Борис",
  "lastname": "Акунин"
}'
```

### Создание книги с привязкой к существующему автору

```sh
curl -X 'POST' \
  'http://localhost/api/books' \
  -H 'accept: application/ld+json' \
  -H 'Content-Type: application/ld+json' \
  -d '{
  "name": "Поэма об осени",
  "year": 2024,
  "publisher": "api/publishers/1"
}'
```

## Остановить контейнеры

```sh
docker compose down
```
