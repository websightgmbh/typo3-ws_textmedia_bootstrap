<?php
defined('TYPO3_MODE') or die();

(function () {
    // Register for hook to show preview of tt_content element of CType="wstextmediabootstrap" in page module
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['wstextmediabootstrap']
        = Websight\WsTextmediaBootstrap\Preview\WsTextmediaPreviewRenderer::class;

    if (TYPO3_MODE === 'BE') {
        call_user_func(
            function ($extKey) {
                // Get the extension configuration
                $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extKey]);

                if (!isset($extConf['loadContentElementWizardTsConfig']) || (int)$extConf['loadContentElementWizardTsConfig'] === 1) {
                    // Include new content elements to modWizards
                    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ws_textmedia_bootstrap/Configuration/PageTSconfig/NewContentElementWizard.typoscript">');
                }
            },
            $_EXTKEY
        );
    }
})();
