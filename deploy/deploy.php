<?php

namespace Deployer;

use Deployer\Exception\ConfigurationException;

require 'recipe/typo3.php';

set('application', 'typo3-b4f7-de');
set('repository', 'git@github.com:b4f7/typo3.b4f7.de.git');
set('keep_releases', 5);
set('update_code_strategy', 'clone');

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

task('deploy:npm', function () {
    cd('{{release_path}}');
    run('npm install');
    run('npm run build');
});

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
    'deploy:npm',
    'deploy:db',
    'deploy:language',
    'deploy:cache'
]);

/*
 * Overridden to initialise and update submodules. There might be a better
 * way to do this that doesn't involve copying the whole task.
 */
task('deploy:update_code', function () {
    $git = get('bin/git');
    $repository = get('repository');
    $target = get('target');

    $targetWithDir = $target;
    if (!empty(get('sub_directory'))) {
        $targetWithDir .= ':{{sub_directory}}';
    }

    $bare = parse('{{deploy_path}}/.dep/repo');
    $env = [
        'GIT_TERMINAL_PROMPT' => '0',
        'GIT_SSH_COMMAND' => get('git_ssh_command')
    ];

    start:
    // Clone the repository to a bare repo.
    run("[ -d $bare ] || mkdir -p $bare");
    run("[ -f $bare/HEAD ] || $git clone --mirror $repository $bare 2>&1", ['env' => $env]);

    cd($bare);

    // If remote url changed, drop `.dep/repo` and reinstall.
    if (run("$git config --get remote.origin.url") !== $repository) {
        cd('{{deploy_path}}');
        run("rm -rf $bare");
        goto start;
    }

    run("$git remote update 2>&1", ['env' => $env]);


    // Copy to release_path.
    if (get('update_code_strategy') === 'archive') {
        run("$git archive $targetWithDir | tar -x -f - -C {{release_path}} 2>&1");
    } elseif (get('update_code_strategy') === 'clone') {
        cd('{{release_path}}');
        run("$git clone --recurse-submodules -l $bare .");
        run("$git remote set-url origin $repository", ['env' => $env]);
        run("$git checkout --recurse-submodules --force $target");
    } else {
        throw new ConfigurationException(parse("Unknown `update_code_strategy` option: {{update_code_strategy}}."));
    }

    // Save git revision in REVISION file.
    $rev = escapeshellarg(run("$git rev-list $target -1"));
    run("echo $rev > {{release_path}}/REVISION");
});

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
