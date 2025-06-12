## Diagnostyka task

1. Clone the repository:

```bash
git clone https://github.com/marioooo0o/diagnostyka-task.git
```

2. Move into the cloned repository.

```bash
cd diagnostyka-task
```

3. Copy .env.example to .env file and change DB_HOST

```php
...
DB_HOST=mysql
...
```

4. Run docker and wait for about one minute

```
docker-compose up -d
// Run the following command to check docker status
docker ps
```

5. Enter workspace container and run php commands (run only once when initialize the project)

```
docker exec -it diagnostyka-task-laravel.test-1 bash
composer install
php artisan migrate --seed
```

6. To run tests, run the following command in the workspace container:

```bash
php artisan test
```
