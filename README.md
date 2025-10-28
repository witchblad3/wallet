# Wallet API (Laravel + Postgres + Docker)


Мини‑сервис учёта баланса пользователей. Поддерживает пополнение, списание, перевод и получение текущего баланса.


## Стек
- PHP 8.3, Laravel 11
- PostgreSQL 16
- Docker (php-fpm, nginx, postgres)
- Spatie Laravel Data (DTO)


## Быстрый старт
1. `cp .env.example .env`
2. `docker compose up -d --build`
3. `docker compose exec app composer install`
4. `docker compose exec app php artisan key:generate`
5. `docker compose exec app php artisan migrate --seed`
6. Проверка: `curl http://localhost:8080/api/health`


## API
- `POST /api/deposit` `{ user_id, amount, comment? }`
- `POST /api/withdraw` `{ user_id, amount, comment? }`
- `POST /api/transfer` `{ from_user_id, to_user_id, amount, comment? }`
- `GET /api/balance/{user_id}` → `{ user_id, balance }`

В проекте лежит файл с JSON для postman - Create Wallet API.postman_collection.json


## Надёжность
- Все денежные операции в транзакциях
- NUMERIC(14,2); без float
- Атомарные SQL‑обновления, CHECK(balance>=0)

## Лицензия
MIT

Структура
Controller получает Request → маппит в DTO (Spatie Data) → вызывает Action
Action инкапсулирует бизнес‑правила и транзакцию БД
Repository даёт атомарные операции чтения/записи под Postgres (UPSERT, UPDATE..WHERE balance>=amount)
Resource формирует JSON‑ответы
Миграции создают users, accounts (баланс), transactions (леджер) + индексы и CHECK
Docker поднимает php‑fpm, nginx, postgres
