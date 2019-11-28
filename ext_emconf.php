<?php

$EM_CONF[$_EXTKEY] = [
    'title'            => 'Text & Media Element for Bootstrap 3',
    'description'      => 'Fluid Styled Content overlay and standalone template for Text & Media',
    'category'         => 'plugin',
    'author'           => 'Tilman Schlereth, Cedric Ziel',
    'author_email'     => 'schlereth@websight.de',
    'author_company'   => 'websight gmbh',
    'state'            => 'beta',
    'internal'         => '',
    'uploadfolder'     => '0',
    'createDirs'       => '',
    'modify_tables'    => '',
    'clearCacheOnLoad' => 0,
    'version'          => '3.0.0',
    'constraints'      => [
        'depends'   => [
            'typo3' => '8.7.0-8.7.99',
            'fluid_styled_content' => '',
            'fluid_styled_responsive_images' => '',
        ],
        'conflicts' => [],
        'suggests'  => [],
    ],
    'autoload'         => [
        'psr-4' => ['Websight\\WsTextmediaBootstrap\\' => 'Classes']
    ]
];
