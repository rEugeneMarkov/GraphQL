
echo "Running Migrations and Seeds"

docker-compose exec php php tests/functional/bootstrap/runMigrations.php

docker-compose exec php vendor/bin/paratest --functional

echo "Rollback Migrations"

docker-compose exec php php tests/functional/bootstrap/rollbackMigrations.php
