<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Text & Media Element for Bootstrap 3',
    'description' => 'Fluid Styled Content overlay and standalone template for Text & Media',
    'version' => '4.0.0',
    'category' => 'plugin',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99',
            'fluid_styled_content' => '',
            'fluid_styled_responsive_images' => '',
        ],
    ],
    'state' => 'beta',
    'author' => 'Tilman Schlereth, Cedric Ziel',
    'author_email' => 'schlereth@websight.de',
    'author_company' => 'websight gmbh',
    'autoload' => [
        'psr-4' => [
            'Websight\\WsTextmediaBootstrap\\' => 'Classes'
        ]
    ],
];
