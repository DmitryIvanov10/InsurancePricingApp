init:
	composer install
	yes | php bin/console doctrine:migrations:migrate
