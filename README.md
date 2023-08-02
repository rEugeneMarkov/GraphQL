# GraphQL
**docker compose exec php vendor/bin/phinx migrate**

**docker compose exec php vendor/bin/phinx seed:run**

#### Before testing, run migrations and seeding the test database.

**docker compose exec php vendor/bin/phinx migrate -e testing**

**docker compose exec php vendor/bin/phinx seed:run -e testing**

**docker compose exec php vendor/bin/phpunit**

**docker compose exec php vendor/bin/paratest --functional**

**docker compose exec php vendor/bin/paratest --functional**
