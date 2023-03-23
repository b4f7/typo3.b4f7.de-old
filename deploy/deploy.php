<?php

namespace Deployer;

require 'recipe/typo3.php';

set('application', 'typo3-b4f7-de');
set('repository', 'git@github.com:b4f7/typo3.b4f7.de.git');
set('keep_releases', 5);

host('production')
    ->setHostname('typo3.b4f7.de')
    ->setRemoteUser('deployer')
    ->set('branch', 'master')
    ->set('public_urls', ['https://typo3.b4f7.de/'])
    ->set('deploy_path', '/var/www/typo3.b4f7.de');

set('typo3_webroot', 'public');
add('shared_files', [
    '{{typo3_webroot}}/typo3conf/AdditionalConfiguration.php',
    '.env',
]);
add('writable_dirs', ['config', 'var']);

task('deploy:cache', function () {
    cd('{{release_path}}');
    run('vendor/bin/typo3 cache:flush');
    run('vendor/bin/typo3 cache:warmup');
});

task('deploy:db', function () {
    cd('{{release_path}}');
    run('vendor/bin/typo3cms database:updateschema');
    run('vendor/bin/typo3 upgrade:run');
});

task('deploy:language', function () {
    cd('{{release_path}}');
    run('vendor/bin/typo3 language:update');
});

task('deploy:additional', [
    'deploy:db',
    'deploy:language',
    'deploy:cache'
]);

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'deploy:additional',
    'deploy:publish',
]);

after('deploy:failed', 'deploy:unlock');

task('pull_database', function () {
    cd('{{deploy_path}}/current');

    info('Dumping remote database...');
    run('php vendor/bin/typo3cms database:export | gzip > /tmp/prod-dump.sql.gz');

    info('Downloading dump...');
    download('/tmp/prod-dump.sql.gz', '/tmp');
    run('rm /tmp/prod-dump.sql.gz');

    info('Importing dump locally...');
    if (getenv('IS_DDEV_PROJECT')) {
        runLocally('gzip -dc /tmp/prod-dump.sql.gz | mysql -udb -pdb db');
    } else {
        runLocally('ddev import-db --src=/tmp/prod-dump.sql.gz');
    }
    runLocally('rm /tmp/prod-dump.sql.gz');
})->desc('Pull remote database');

task('pull_assets', function () {
    download('{{deploy_path}}/shared/public/fileadmin/', './public/fileadmin/');
})->desc('Pull remote assets');

task('pull', [
    'pull_database',
    'pull_assets'
])->desc('Pull remote database and assets');
