# Ornithar

Ornithar — API-first приложение для импорта, классификации и анализа личных финансовых операций.

Сейчас проект содержит только техническую основу: Symfony API, PostgreSQL, Doctrine, health endpoint и проверки качества. Финансовая бизнес-логика ещё не реализована.

## Стек

- PHP 8.5
- Symfony 8.1
- PostgreSQL 18
- FrankenPHP (Caddy и PHP runtime в одном контейнере)
- Doctrine ORM и Doctrine Migrations
- PHPUnit и PHPStan
- Docker Compose

## Требования

Для локальной разработки нужны Docker Engine с Docker Compose. PHP и Composer на хосте не требуются: зависимости устанавливаются при сборке Docker-образа.

## Первый запуск

```bash
docker compose up -d --build
docker compose ps
```

`api` будет доступен на порту `5020`, а PostgreSQL запускается во внутренней Docker-сети. При необходимости после изменения зависимостей пересоберите образ:

```bash
docker compose build api
docker compose up -d
```

Для сокращения этих команд можно использовать [Task](https://taskfile.dev/): `task up`, `task down`, `task test`, `task phpstan` и `task check`.

## Остановка

```bash
docker compose down
```

Данные PostgreSQL сохраняются в именованном Docker volume. Чтобы удалить их намеренно, выполните `docker compose down --volumes`.

## Проверки

Все команды запускаются внутри контейнера `api`:

```bash
docker compose exec api composer test
docker compose exec api composer phpstan
docker compose exec api composer check
```

`composer check` последовательно запускает PHPUnit и PHPStan.

## PostgreSQL и Doctrine

Параметры локальной базы определены в `.env`; для Docker Compose используются база, пользователь и пароль `ornithar`. Это значения только для локальной разработки.

Проверить подключение Doctrine можно так:

```bash
docker compose exec api php bin/console doctrine:migrations:status
```

Подключиться к PostgreSQL напрямую:

```bash
docker compose exec postgres psql -U ornithar -d ornithar
```

## Health endpoint

Application health-check не обращается к PostgreSQL:

```bash
curl http://localhost:5020/api/v1/health
```

Ожидаемый ответ:

```json
{"status":"ok"}
```

## Планы

В следующих этапах появятся импорт выписок, классификация операций и аналитика личных финансов. Сейчас эти возможности не реализованы.
