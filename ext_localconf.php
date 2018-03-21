<?php
defined('TYPO3_MODE') || die('Access denied.');



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
					     iconIdentifier = ext-'.$_EXTKEY.'-wizard-icon

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
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
                wizards.newContentElement.wizardItems.plugins {
                    elements {
                        tp3facebook {
                            iconIdentifier = ext-'.$_EXTKEY.'-fbpage-wizard-icon
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
        );

        /*
   * Icons
   */
        if (TYPO3_MODE === 'BE') {
            $icons = [
                'ext-'.$_EXTKEY.'-wizard-icon' => 'user_plugin_tp3share.svg',
                'ext-'.$_EXTKEY.'-fbpage-wizard-icon' => 'user_plugin_tp3facebook.svg',

            ];
            $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
            foreach ($icons as $identifier => $path) {
                $iconRegistry->registerIcon(
                    $identifier,
                    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                    ['source' => 'EXT:'.$_EXTKEY.'/Resources/Public/Icons/' . $path]
                );
            }
        }
   
