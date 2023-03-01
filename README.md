# TYPO3@b4f7

[![Build](https://github.com/b4f7/typo3.b4f7.de/actions/workflows/build.yml/badge.svg)](https://github.com/b4f7/typo3.b4f7.de/actions/workflows/build.yml)

The TYPO3 project for the website running at https://typo3.b4f7.de/. Using the TYPO3 Bootstrap Package and running on
nginx, PHP-FPM, PostgreSQL and redis.

## Prerequisites

- Docker
- ddev

## Setup

```bash
ddev restart
ddev auth ssh
ddev composer install
ddev psql db -c "create user typo3;" # the remote database user must exist locally to use import-db
```

## Fetch data from remote

To pull the remote database and assets, run:

```bash
composer pull
```

**Note:** Because this uses ddev's import-db function, it cannot be run from within ddev and thus requires PHP and
composer to be installed locally. It is also possible to manually sync the `fileadmin` directory (by whatever means
preferred) and import a manually created db dump using:

```bash
ddev import-db --src=db-dump.sql[.gz]
```

## Deploy

```bash
ddev composer deploy
```

## License

GPL-2.0 or later in accordance with TYPO3 source.
