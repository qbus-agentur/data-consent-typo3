<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Data Consent',
    'description' => '',
    'category' => '',
    'author' => 'Benjamin Franzke',
    'author_email' => 'bfr@qbus.de',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '0.2.6',
    'constraints' => array(
        'depends' => array(
            'typo3' => '7.6.0-10.4.99',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
        ),
    ),
    'autoload' => array(
        'psr-4' => array(
            'Qbus\\DataConsent\\' => 'Classes',
        ),
    ),
);
