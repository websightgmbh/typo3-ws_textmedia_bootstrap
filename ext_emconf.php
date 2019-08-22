<?php

$EM_CONF[$_EXTKEY] = [
    'title'            => 'Text & Media Element for Bootstrap 3',
    'description'      => 'Fluid Styled Content overlay and standalone template for Text & Media',
    'category'         => 'plugin',
    'author'           => 'Cedric Ziel',
    'author_email'     => 'ziel@websight.de',
    'author_company'   => 'websight gmbh',
    'state'            => 'beta',
    'internal'         => '',
    'uploadfolder'     => '0',
    'createDirs'       => '',
    'modify_tables'    => '',
    'clearCacheOnLoad' => 0,
    'version'          => '2.1.2',
    'constraints'      => [
        'depends'   => [
            'typo3' => '9.5.0-9.5.99',
            'fluid_styled_content' => '9.5.0-9.5.99',
            'responsive_images' => '2.0.0-2.99.99',
        ],
        'conflicts' => [],
        'suggests'  => [],
    ],
    'autoload'         => [
        'psr-4' => ['Websight\\WsTextmediaBootstrap\\' => 'Classes']
    ]
];
