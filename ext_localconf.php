<?php
defined('TYPO3_MODE') or die();

(function () {
    // Register for hook to show preview of tt_content element of CType="wstextmediabootstrap" in page module
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['wstextmediabootstrap']
        = Websight\WsTextmediaBootstrap\Preview\WsTextmediaPreviewRenderer::class;

    if (TYPO3_MODE === 'BE') {
        // Include new content elements to modWizards
        if ((bool)TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)->get('ws_textmedia_bootstrap', 'loadContentElementWizardTsConfig') === true) {
            TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ws_textmedia_bootstrap/Configuration/PageTSconfig/NewContentElementWizard.typoscript">');
        }
    }
})();
