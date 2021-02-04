# Checkpoint 4 - Wild Circus - Symfony 5.*

## Requirements

- Php ^7.2 http://php.net/manual/fr/install.php;
- Composer https://getcomposer.org/download/;
- Yarn https://classic.yarnpkg.com/en/docs/install/#debian-stable;
- Node https://nodejs.org/en/;

## Installation

1. Clone the current repository.

2. Move into the directory and create an `.env.local` file.
   **This one is not committed to the shared repository.**

3. Execute the following commands in your working folder to install the project:

```bash
# Install dependencies
composer install
yarn install
php bin/console ckeditor:install
php bin/console assets:install public

# Create 'ideoz' DB
php bin/console doctrine:database:create

# Execute migrations and create tables
php bin/console doctrine:migrations:migrate

# Load fixtures
php bin/console doctrine:fixtures:load
```

> Reminder: Don't use composer update to avoid problem

## Usage

Run `yarn encore dev` to build assets

Run `php -S localhost:8000 -t public` or `symfony server:start` to launch server

## Authors

Amélie Roussel
