# Galaxy — социальная сеть на Laravel + Vue

Учебный fullstack-проект: лента, профили, чаты и админка. Стек: **Laravel 12**, **Vue 3**, **Inertia.js**, **Tailwind CSS**.

## Что умеет

- Регистрация / логин / сброс пароля (Laravel Breeze)
- Профили пользователей, подписки (follow / unfollow)
- Посты: просмотр, комментарии, лайки, репосты
- Чаты и сообщения
- Уведомления
- Админ-панель: посты, категории, теги, чаты, сообщения, профили, статистика
- Real-time через Laravel Echo / Pusher
- Кэш Redis, очереди, Laravel Telescope

## Стек

| Слой | Технологии |
|------|------------|
| Backend | PHP 8.2+, Laravel 12, Inertia, Sanctum / JWT |
| Frontend | Vue 3, Inertia.js, Tailwind, Vite |
| Real-time | Laravel Echo, Pusher |
| Прочее | Redis (Predis), queues, Telescope |

## Быстрый старт

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed

npm install
npm run dev

php artisan serve
```

Или одной командой (сервер + queue + vite):

```bash
composer run dev
```

## Структура

```
app/Http/Controllers/Client   — клиентская часть (лента, профили, чаты)
app/Http/Controllers/Admin    — админка
resources/js/Pages/Client     — Vue-страницы клиента
resources/js/Pages/Admin      — Vue-страницы админки
routes/client.php             — клиентские маршруты
routes/admin.php              — админские маршруты
```

## Автор

[Iskandar Sadykov](https://github.com/mrsadykov) · [FL.ru](https://www.fl.ru/users/mrsadykov96/)

MIT
