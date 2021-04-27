<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Text & Media Element for Bootstrap 3',
    'description' => 'Fluid Styled Content overlay and standalone template for Text & Media',
    'version' => '5.0.0',
    'category' => 'plugin',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99',
            'fluid_styled_content' => '',
            'fluid_styled_responsive_images' => '10.4.0-10.4.99',
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
