docker-compose up -d --build
docker-compose run --rm composer i
docker-compose run --rm npm install
docker-compose run --rm npm run build
docker-compose run --rm artisan migrate:fresh --seed
docker-compose run --rm artisan test tests/Feature/LinkControllerTest.php
#docker-compose run --rm artisan test --testsuite=Feature --stop-on-failure
docker-compose run --rm artisan optimize
