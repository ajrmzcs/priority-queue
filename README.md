## Priority Queue Project

Test project to send jobs to a **Redis** queue with low and high priority. 
Priority jobs have:
- submitter_id (provided by client)
- processor_id (updated when job is dipatched to the queue)
- priority (provided by client (enum: low, high))
- command (provided by client (enum: command_1, command_2))
- start_date (updated by job for statistics)
- end_date (updated by job for statistics)

## Installation steps
1. Clone repository
2. cd to project folder and run: 
```
composer install
```
3. copy .env.example to .env
4. Make sure you have installed **docker** in your local machine
5. Build local development env. with **docker-compose** Run:
```
docker-compose build --no-cache && docker-compose up -d --force-recreate && docker-compose logs -f
```
6. Access php cli:
```
docker exec -it --user root priority-queue-app bash
``` 
7. Run migrations:
```
php artisan migrate
```
8. Run supervisor:
```
service supervisor start
```

## List of helpful docker commands
```
Build: 
docker-compose build --no-cache && docker-compose up -d --force-recreate && docker-compose logs -f

Up:
docker-compose up -d && docker-compose logs -f

Down:
docker-compose stop

PHP:
docker exec -it --user root priority-queue-app bash

MySql:
docker exec -it priority-db bash -c "mysql -upriority -psecret priority"

Redis:
docker exec -it redis redis-cli

Supervisor:
service supervisor start
```

You can either use postman or use this [small laravel client](https://github.com/ajrmzcs/priority-queue-client).
