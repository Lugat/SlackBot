install:
	composer install

run-tests:
	vendor/bin/codecept run

migrate:
	php yii migrate --interactive=0 --migrationPath=@yii/rbac/migrations/
	php yii migrate --interactive=0