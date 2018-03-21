<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

/* Set up the tt_content fields for the frontend plugins */

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['tp3social_tp3share']='layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['tp3social_tp3share']='pi_flexform';

/* register the plugins */
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(Array('LLL:EXT:tp3_social/Resources/Private/Languages/locallang_csh_tx_tp3social_domain_model_tp3shares.xlf:tp3_social.tx_tp3_social_domain_model_tp3share', 'tp3social_tp3share'),'list_type', 'tp3_social');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Tp3.Tp3Social',
    'Tp3share',
    'tp3 Shares'
);
/* Add the flexforms to the TCA */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('tp3social_tp3share', 'FILE:EXT:tp3_social/Configuration/FlexForms/flexform.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3social_domain_model_tp3shares', 'EXT:tp3_social/Resources/Private/Language/locallang_csh_tx_tp3social_domain_model_tp3shares.xlf');


/* Set up the tt_content fields for the frontend plugins */

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['tp3social_tp3facebook']='layout,select_key,pages,recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['tp3social_tp3facebook']='pi_flexform';

/* register the plugins */
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(Array('LLL:EXT:tp3_social/Resources/Private/Languages/locallang_db.xlf:tx_tp3_social_tp3facebook', 'tp3social_tp3facebook'),'list_type', 'tp3_social');


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Tp3.Tp3Social',
    'Tp3facebook',
    'tp3 Facebook'
);

/* Add the flexforms to the TCA */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('tp3social_tp3facebook', 'FILE:EXT:tp3_social/Configuration/FlexForms/flexform_fbpage.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3social_tp3facebook', 'EXT:tp3_social/Resources/Private/Language/locallang_csh_tx_tp3social_domain_model_tp3shares.xlf');

?>