<?php

declare(strict_types=1);

defined('TYPO3') || die();

call_user_func(function () {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        'b4f7_site_package',
        'Configuration/TypoScript',
        'Site Package (typo3.b4f7.de)'
    );
});
