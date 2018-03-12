<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
	{

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Tp3.Tp3Social',
            'Tp3share',
            [
                'Tp3Shares' => 'list','page'
            ],
            // non-cacheable actions
            [
                'Tp3Shares' => ''
            ]
        );




        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][\Tp3\Tp3Social\Updates\Tp3SocialTp3shareContentElementUpdate::class]
            = \Tp3\Tp3Social\Updates\Tp3SocialTp3shareContentElementUpdate::class;
	// wizards
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
		'mod {
			wizards.newContentElement.wizardItems.plugins {
				elements {
					tp3share {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey) . 'Resources/Public/Icons/user_plugin_tp3share.svg
						title = LLL:EXT:tp3_social/Resources/Private/Language/locallang_db.xlf:tx_tp3_social_domain_model_tp3share
						description = LLL:EXT:tp3_social/Resources/Private/Language/locallang_db.xlf:tx_tp3_social_domain_model_tp3share.description
						tt_content_defValues {
							CType = list
							list_type = tp3social_tp3share
						}
					}
				}
				show = *
			}
	   }'
	);
        // wizards
       /* \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
                wizards.newContentElement.wizardItems.plugins {
                    elements {
                        tp3facebook {
                            icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey) . 'Resources/Public/Icons/user_plugin_tp3facebook.svg
                            title = LLL:EXT:tp3_social/Resources/Private/Language/locallang_db.xlf:tx_tp3_social_tp3facebook
                            description = LLL:EXT:tp3_social/Resources/Private/Language/locallang_db.xlf:tx_tp3_social_tp3facebook.description
                            tt_content_defValues {
                                CType = list
                                list_type = tp3social_tp3facebook
                            }
                        }
                    }
                    show = *
                }
           }'
        );*/
    },
    $_EXTKEY
);
