## Supermetrics Assignment
author: Salah Farzin

Library:
1. PHPUnit for test purpose
2. Symfony/Dotenv to load configuration with zero overhead

### Build and run

``` 
    docker-compose build

    docker-compose up

    docker exec -it php8 composer install
```

After this PHP runs on http://localhost:8000

### Test

```  docker exec -it php8 ./vendor/bin/phpunit  ```
