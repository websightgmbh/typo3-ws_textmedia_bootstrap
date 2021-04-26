<?php
defined('TYPO3_MODE') or die();

$languageFilePrefix = 'LLL:EXT:ws_textmedia_bootstrap/Resources/Private/Language/locallang_db.xlf:ws_textmedia_bootstrap.';

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['wstextmediabootstrap'] = 'mimetypes-x-content-text-media';

// Add CType 'wstextmediabootstrap'
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        $languageFilePrefix . 'ce_wizard.title',
        'wstextmediabootstrap',
        'content-textmedia'
    ],
    'header',
    'after'
);

$GLOBALS['TCA']['tt_content']['types']['wstextmediabootstrap'] = array_merge_recursive(
    $GLOBALS['TCA']['tt_content']['types']['textmedia'],
    [

    ]
);

// Add category tab when categories column exits
if (!empty($GLOBALS['TCA']['tt_content']['columns']['categories'])) {
    $GLOBALS['TCA']['tt_content']['types']['wstextmediabootstrap']['showitem'] .=
        ',--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
        categories';
}

/*
 * Grid palette
 */
$GLOBALS['TCA']['tt_content']['palettes']['gridSettings'] = [
    'showitem' => '
        ,--div--;Grid,
        ws_textmedia_bootstrap_image_size;' . $languageFilePrefix . 'col.ws_textmedia_bootstrap_image_size,
    '
];

$ttContentColumns = [
    'ws_textmedia_bootstrap_image_size' => [
        'exclude' => 1,
        'label' => $languageFilePrefix . 'col.ws_textmedia_bootstrap_image_size',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    '',
                    '0'
                ],
                [
                    '1/12',
                    '1'
                ],
                [
                    '2/12',
                    '2'
                ],
                [
                    '3/12 (25%)',
                    '3'
                ],
                [
                    '4/12',
                    '4'
                ],
                [
                    '5/12',
                    '5'
                ],
                [
                    '6/12 (50%)',
                    '6'
                ],
                [
                    '7/12',
                    '7'
                ],
                [
                    '8/12',
                    '8'
                ],
                [
                    '9/12 (75%)',
                    '9'
                ],
                [
                    '10/12',
                    '10'
                ],
                [
                    '11/12',
                    '11'
                ],
                [
                    '12/12 (100%)',
                    '12'
                ],
            ],
            'default' => 6
        ]
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $ttContentColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content',
    '--palette--;' . $languageFilePrefix . 'palette.grid_settings;gridSettings', 'textmedia', 'after:imagecols');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content',
    '--palette--;' . $languageFilePrefix . 'palette.grid_settings;gridSettings', 'wstextmediabootstrap',
    'after:imagecols');
