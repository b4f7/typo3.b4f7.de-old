# TYPO3@b4f7

[![Build](https://github.com/b4f7/typo3.b4f7.de/actions/workflows/build.yml/badge.svg)](https://github.com/b4f7/typo3.b4f7.de/actions/workflows/build.yml)

The TYPO3 project for the website running at https://typo3.b4f7.de/. Using the TYPO3 Bootstrap Package and running on
nginx, PHP-FPM, MySQL and redis. Hosted on Lightsail.

## Prerequisites

- Docker
- ddev

## Setup

```bash
ddev restart
ddev auth ssh
ddev composer install
```

## Fetch data from remote

To fetch the production database and assets and import them into ddev:

```bash
composer pull
```

## Deploy

```bash
ddev composer deploy
```

## License

GPL-2.0 or later in accordance with TYPO3 source.
