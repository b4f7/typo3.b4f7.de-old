<?php

return [
    'BE' => [
        'debug' => false,
        'explicitADmode' => 'explicitAllow',
        'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\Argon2iPasswordHash',
            'options' => [],
        ],
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8mb4',
                'driver' => 'pdo_mysql',
                'tableoptions' => [
                    'charset' => 'utf8mb4',
                    'collate' => 'utf8mb4_unicode_ci',
                ],
            ],
        ],
    ],
    'EXTCONF' => [
        'lang' => [
            'availableLanguages' => [
                'de',
            ],
        ],
    ],
    'EXTENSIONS' => [
        'aus_driver_amazon_s3' => [
            'dnsPrefetch' => '1',
            'doNotLoadAmazonLib' => '0',
            'enablePermissionsCheck' => '0',
        ],
        'backend' => [
            'backendFavicon' => '',
            'backendLogo' => '',
            'loginBackgroundImage' => '',
            'loginFootnote' => '',
            'loginHighlightColor' => '',
            'loginLogo' => '',
            'loginLogoAlt' => '',
        ],
        'bootstrap_package' => [
            'disableCssProcessing' => '0',
            'disableGoogleFontCaching' => '0',
            'disablePageTsBackendLayouts' => '0',
            'disablePageTsContentElements' => '0',
            'disablePageTsRTE' => '0',
            'disablePageTsTCADefaults' => '0',
            'disablePageTsTCEFORM' => '0',
            'disablePageTsTCEMAIN' => '0',
        ],
        'extensionmanager' => [
            'automaticInstallation' => '1',
            'offlineMode' => '0',
        ],
        'scheduler' => [
            'maxLifetime' => '1440',
            'showSampleTasks' => '1',
        ],
        'solr' => [
            'allowSelfSignedCertificates' => '0',
            'includeGlobalQParameterInCacheHash' => '0',
            'monitoringType' => '0',
            'pluginNamespaces' => 'tx_solr',
            'useConfigurationFromClosestTemplate' => '0',
            'useConfigurationMonitorTables' => '',
            'useConfigurationTrackRecordsOutsideSiteroot' => '1',
        ],
        'tt_address' => [
            'backwardsCompatFormat' => '%1$s %3$s',
            'readOnlyNameField' => '1',
            'storeBackwardsCompatName' => '1',
        ],
        'wv_deepltranslate' => [
            'apiKey' => '',
            'apiUrl' => 'https://api.deepl.com/v2/translate',
            'deeplFormality' => 'default',
            'googleapiKey' => '',
            'googleapiUrl' => 'https://translation.googleapis.com/language/translate/v2',
        ],
    ],
    'FE' => [
        'cacheHash' => [
            'enforceValidation' => true,
            'excludedParameters' => [
                '_', // jQuery's cache-busting parameter
            ],
        ],
        'debug' => false,
        'disableNoCacheParameter' => true,
        'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\Argon2iPasswordHash',
            'options' => [],
        ],
    ],
    'GFX' => [
        'processor' => 'GraphicsMagick',
        'processor_allowTemporaryMasksAsPng' => false,
        'processor_colorspace' => 'RGB',
        'processor_effects' => false,
        'processor_enabled' => true,
        'processor_path' => '/usr/bin/',
        'processor_path_lzw' => '/usr/bin/',
    ],
    'LOG' => [
        'TYPO3' => [
            'CMS' => [
                'deprecations' => [
                    'writerConfiguration' => [
                        'notice' => [
                            'TYPO3\CMS\Core\Log\Writer\FileWriter' => [
                                'disabled' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'SYS' => [
        'caching' => [
            'cacheConfigurations' => [
                'hash' => [
                    'backend' => 'TYPO3\CMS\Core\Cache\Backend\RedisBackend',
                    'options' => [
                        'database' => 2,
                        'hostname' => getenv('REDIS_HOST'),
                        'port' => getenv('REDIS_PORT'),
                    ],
                ],
                'imagesizes' => [
                    'backend' => 'TYPO3\CMS\Core\Cache\Backend\RedisBackend',
                    'options' => [
                        'compression' => true,
                        'database' => 3,
                        'hostname' => getenv('REDIS_HOST'),
                        'port' => getenv('REDIS_PORT'),
                    ],
                ],
                'pages' => [
                    'backend' => 'TYPO3\CMS\Core\Cache\Backend\RedisBackend',
                    'options' => [
                        'compression' => true,
                        'database' => 4,
                        'hostname' => getenv('REDIS_HOST'),
                        'port' => getenv('REDIS_PORT'),
                    ],
                ],
                'pagesection' => [
                    'backend' => 'TYPO3\CMS\Core\Cache\Backend\RedisBackend',
                    'options' => [
                        'compression' => true,
                        'database' => 5,
                        'hostname' => getenv('REDIS_HOST'),
                        'port' => getenv('REDIS_PORT'),
                    ],
                ],
                'rootline' => [
                    'backend' => 'TYPO3\CMS\Core\Cache\Backend\RedisBackend',
                    'options' => [
                        'compression' => true,
                        'database' => 6,
                        'hostname' => getenv('REDIS_HOST'),
                        'port' => getenv('REDIS_PORT'),
                    ],
                ],
            ],
        ],
        'devIPmask' => '',
        'displayErrors' => 0,
        'encryptionKey' => 'baa4f927b32b1e622189ccddbf28e74fef375e56a36918d47ac6d960693ad4d34d2bef8c92cbafb3fd8f9251cc6ce856',
        'exceptionalErrors' => 4096,
        'features' => [
            'yamlImportsFollowDeclarationOrder' => true,
        ],
        'sitename' => 'TYPO3@b4f7',
        'systemMaintainers' => [
            1,
        ],
    ],
];
