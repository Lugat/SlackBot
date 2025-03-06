install:
	composer install

run-tests:
	vendor/bin/codecept run

rbac:
	php yii rbac

migrate:
	php yii migrate --interactive=0 --migrationPath=@yii/rbac/migrations/
	php yii migrate --interactive=0