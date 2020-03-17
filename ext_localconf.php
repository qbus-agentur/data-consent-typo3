<?php
defined('TYPO3_MODE') || die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output']['data_consent_iframe_removal'] = \Qbus\DataConsent\ContentPostProc::class . '->postProcess';
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['iframe_placeholder'] =  \Qbus\DataConsent\IframePlaceholderEidController::class . '::processRequest';
