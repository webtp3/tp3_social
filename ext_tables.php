 <?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Tp3.Tp3Social',
            'Tp3share',
            'tp3 Shares'
        );


        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3social_domain_model_tp3shares', 'EXT:tp3_social/Resources/Private/Language/locallang_csh_tx_tp3social_domain_model_tp3shares.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tp3social_tp3facebook', 'EXT:tp3_social/Resources/Private/Language/locallang_csh_tx_tp3social_domain_model_tp3shares.xlf');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3social_domain_model_tp3shares');
         // $TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1'] ='pi_flexform';
        
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey.'_tp3share', 'FILE:EXT:'.$extKey . '/Configuration/FlexForms/flexform.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey.'_tp3facebook', 'FILE:EXT:'.$extKey . '/Configuration/FlexForms/flexform_fbpage.xml');

    },
    $_EXTKEY
);
