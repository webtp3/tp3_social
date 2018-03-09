<?php
defined('TYPO3_MODE') || die();
/*
 * // Add an entry in the static template list found in sys_templates for static TS
 *
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'tp3_social',
    'Configuration/TypoScript',
    'Tp3share'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('tp3_social', 'Configuration/TypoScript/Plugin', 'Tp3facebook');
