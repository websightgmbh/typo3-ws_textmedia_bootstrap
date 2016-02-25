<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(function ($extKey) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $extKey,
        'Configuration/TypoScript/Replace',
        'Bootstrap Textmedia: Replace'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $extKey,
        'Configuration/TypoScript/Standalone',
        'Bootstrap Textmedia: Standalone'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
        $extKey,
        'Configuration/PageTSconfig/NewContentElementWizard.typoscript',
        'Bootstrap Textmedia: New Content Element Wizard Items (Standalone)'
    );
}, 'ws_textmedia_bootstrap');
