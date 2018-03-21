 <?php
defined('TYPO3_MODE') || die('Access denied.');



 \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3social_facebook');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tp3social_domain_model_tp3shares');
         // $TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1'] ='pi_flexform';

