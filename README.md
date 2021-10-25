# Web-pages analyzer

## [Demo](https://secure-shelf-87936.herokuapp.com/)

### Hexlet tests and linter status:

[![Actions Status](https://github.com/paparrot/php-project-lvl3/workflows/hexlet-check/badge.svg)](https://github.com/paparrot/php-project-lvl3/actions)
[![Laravel](https://github.com/paparrot/php-project-lvl3/actions/workflows/laravel.yml/badge.svg)](https://github.com/paparrot/php-project-lvl3/actions/workflows/laravel.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/8495b700c3c406fd5b3c/maintainability)](https://codeclimate.com/github/paparrot/php-project-lvl3/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/8495b700c3c406fd5b3c/test_coverage)](https://codeclimate.com/github/paparrot/php-project-lvl3/test_coverage)

## Requirements

- PHP ^7.3.0
- Extensions: mbstring, curl, dom, xml, zip, sqlite3
- Composer
- Node.js & npm
- Postgres
- heroku cli

## Download

```bash
# 1. Download
git clone git@github.com:paparrot/php-project-lvl3.git

# 2. Configure Database
DB_CONNECTION=pgsql
DB_HOST=db
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=password

# 3. Install dependencies
make setup
```

## Start 
```bash
make start
```

## CLI commands
```bash
# Open REPL
make console

# See logs
make log

# Lint project
make lint

# Start tests
make test 

# Deploy project to Heroku
make deploy
```
