# TYPO3@b4f7

[![Build](https://github.com/b4f7/typo3.b4f7.de/actions/workflows/build.yml/badge.svg)](https://github.com/b4f7/typo3.b4f7.de/actions/workflows/build.yml)

The TYPO3 project for the website running at https://typo3.b4f7.de/.

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

To pull the remote database and assets, run:

```bash
composer pull
```

**Note:** Because this uses ddev's import-db function, it cannot be run from within ddev and thus requires PHP and
composer to be locally installed.

## Deploy

```bash
ddev composer deploy
```

## License

GPL-2.0 or later in accordance with TYPO3 source.
