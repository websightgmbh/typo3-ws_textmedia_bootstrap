<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'ws_textmedia_bootstrap',
    'Configuration/TypoScript/Replace',
    'Textmedia Bootstrap: Replace'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'ws_textmedia_bootstrap',
    'Configuration/TypoScript/Standalone',
    'Textmedia Bootstrap: Standalone'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'ws_textmedia_bootstrap',
    'Configuration/PageTSconfig/NewContentElementWizard.typoscript',
    'Textmedia Bootstrap: New Content Element Wizard Items (Standalone)'
);
