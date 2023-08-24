# GraphQL
docker compose exec php vendor/bin/phinx migrate

docker compose exec php vendor/bin/phinx seed:run

### Testing...

./tests/paratest.sh
