1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull always -d --wait` to set up and start a fresh Symfony project
4. Run `docker compose down --remove-orphans` to stop the Docker containers.
5. Run `docker ps` to find the PHP docker process running
6. Access the CLI using `docker exec -it symfony-cdv-php-1 bash`.
7. Migrate the database using `bin/console d:m:m`, then load the data fixtures using `bin/console d:f:l`
8. Generate the JWT public and private .pem files using `bin/console lexik:jwt:generate-keypair`

Adminer is accessible on localhost:8080, while the requests are handled from localhost:8081.