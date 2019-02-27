## Развертывание и запуск

- touch .env.local & vim .env.local
```
DATABASE_URL=mysql://ebc:ebc@localhost:3306/ebc
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=123456
```

- composer install
- bin/console server:start 0.0.0.0:8081
- bin/console doctrine:migrations:migrate

## Работа
### web
Авторизация реализована через токен 
Публичная коллекция в postman для работы: https://www.getpostman.com/collections/8229be25c6127aa288d6
- Аутентифицируемся через /login_check и получаем токен
- С bearer-заголовком (токеном) отправляем запрос на /task
- профит

### command
- bin/console task:run 5 5,5,1,7,2,3,5 1  

## Тестирование
```
 ./bin/phpunit
```