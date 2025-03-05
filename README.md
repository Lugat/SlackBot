# Requirements

The minimum requirement by this project template that your Web server supports PHP 8.2.0.

# Setup

## Install dependencies

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project using the following command:

```
composer install
```

Composer will automatically create the database. If not, you may create it yourself by using the following commands.

## Run Migrations

```
php yii migrate
```

# Slash-Commands

Slash commands will return an answer, which only the current user will see.

## UUID

Will generate a UUID.

## Joke

Will tell you a joke

## Password

Will generate a password.

## Translate

Will translate a text into a specified target language.

## Ask

Will ask the AI assistant a question.

# Routines

Routines work similar to cronjobs. They will trigger a certain action based on a schedule. A routine is always bound to a channel.

## Prompt Routine

Will ask Mistral a question and return the answer.

## Birthday Routine

Will show who has birtday today.

# Testing

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](http://codeception.com/).
By default there are 3 test suites:

- `unit`
- `functional`
- `acceptance`

Tests can be executed by running

```
vendor/bin/codecept run
```

The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction. Acceptance tests are disabled by default as they require additional setup since
they perform testing in real browser. 