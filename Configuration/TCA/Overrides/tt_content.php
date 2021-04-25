<?php
defined('TYPO3_MODE') or die();

call_user_func(function () {

    $languageFilePrefix = 'LLL:EXT:ws_textmedia_bootstrap/Resources/Private/Language/Database.xlf:ws_textmedia_bootstrap.';

    $textMediaElementNames = [
        'wstextmediabootstrap' => 'LLL:EXT:ws_textmedia_bootstrap/Resources/Private/Language/Database.xlf:ws_textmedia_bootstrap.ce_wizard.title',
    ];

    foreach ($textMediaElementNames as $element => $label) {

        $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes'][$element] = 'mimetypes-x-content-text-media';

        // Add the CType $element
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            'tt_content',
            'CType',
            [
                $label,
                $element,
                'content-textpic'
            ],
            'header',
            'after'
        );

        $GLOBALS['TCA']['tt_content']['types'][$element] = array_merge_recursive(
            $GLOBALS['TCA']['tt_content']['types']['textmedia'],
            [

            ]
        );

        // Add category tab when categories column exits
        if (!empty($GLOBALS['TCA']['tt_content']['columns']['categories'])) {
            $GLOBALS['TCA']['tt_content']['types'][$element]['showitem'] .=
                ',--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category,
                categories';
        }
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
            'label'   => $languageFilePrefix . 'col.ws_textmedia_bootstrap_image_size',
            'config'  => [
                'type'       => 'select',
                'renderType' => 'selectSingle',
                'items'      => [
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
                'default'    => 6
            ]
        ],
    ];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $ttContentColumns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content',
        '--palette--;' . $languageFilePrefix . 'palette.grid_settings;gridSettings', 'textmedia', 'after:imagecols');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content',
        '--palette--;' . $languageFilePrefix . 'palette.grid_settings;gridSettings', 'wstextmediabootstrap',
        'after:imagecols');
});
