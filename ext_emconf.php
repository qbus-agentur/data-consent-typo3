<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Data Consent',
    'description' => '',
    'category' => '',
    'author' => 'Benjamin Franzke',
    'author_email' => 'bfr@qbus.de',
    'state' => 'stable',
    'version' => '0.3.1',
    'constraints' => [
        'depends' => [
            'typo3' => '10.0.0-11.5.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Qbus\\DataConsent\\' => 'Classes',
        ],
    ],
];
