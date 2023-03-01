<?php

namespace Deployer;

require 'recipe/typo3.php';

set('application', 'typo3-b4f7-de');
set('repository', 'git@github.com:b4f7/typo3.b4f7.de.git');
set('keep_releases', 5);

host('production')
    ->setHostname('web.srv.b4f7.de')
    ->setRemoteUser('deployer')
    ->set('branch', 'master')
    ->set('public_urls', ['https://typo3.b4f7.de/'])
    ->set('deploy_path', '/var/www/typo3.b4f7.de');

set('typo3_webroot', 'public');
add('shared_files', ['{{typo3_webroot}}/typo3conf/AdditionalConfiguration.php']);
add('writable_dirs', ['config', 'var']);

after('deploy:failed', 'deploy:unlock');
