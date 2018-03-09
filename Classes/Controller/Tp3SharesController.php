<?php
namespace Tp3\Tp3Social\Controller;

/***
 *
 * This file is part of the "tp3 social" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Thomas Ruta <email@thomasruta.de>, R&P IT Consulting GmbH
 *
 ***/

use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use \TYPO3\CMS\Core\Page\PageRenderer;
/**
 * Tp3SharesController
 */
class Tp3SharesController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     *
     * @var string;
     */
    private static $extKey = "tp3_social";
    /**
     *
     * @var string;
     */
    private static $layout = "";
    /**
     *
     * @var array;
     */
    private static $conf;

    /**
     * action translate
     *
     * @return string
     */

    private function gettranslation($key){
        //$extensionName = "Tp3share";
        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( $key, $this->extKey);
    }
    /**
     *
     * @var \TYPO3\CMS\Core\Page\PageRenderer();
     */

    protected $pageRenderer;

    /**
    /**
     *
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer();
     */
    protected  $cObjRenderer;
    /**
     *
     * Override actions for page
     * common.
     *
     * @api
     */
    protected function initializeAction()
    {
        $actionMethodName = $this->request->getControllerActionName();

    }
    /**
     * action list
     *
     * @return void
     */
    public function pageAction()
    {
        $cObj = $this->configurationManager->getContentObject();

        $this->conf = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        $fbPlugins = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Tp3\Tp3Social\Plugin\Tp3SharesPlugin::class)->getFacebook($cObj,$this->conf);
        $this->view->assign('fbPlugins', $fbPlugins );
    }
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        //$tp3Shares = $this->tp3SharesRepository->findAll();



        $cObj = $this->configurationManager->getContentObject();

        $this->conf = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        $tp3Shares = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Tp3\Tp3Social\Plugin\Tp3SharesPlugin::class)->getShares($cObj,$this->conf);


        $this->view->assign('tp3Shares', $tp3Shares);
    }
    /**
     * action show
     *
     * @param \Tp3\Tp3Social\Domain\Model\Tp3Shares $tp3Shares
     * @return void
     */
    public function showAction(\Tp3\Tp3Social\Domain\Model\Tp3Shares $tp3Shares)
    {
        $this->view->assign('tp3Shares', $tp3Shares);
    }

    /**
     * This method assigns some default variables to the view
     */
    private function setDefaultViewVars() {
        if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getExtensionVersion('extbase')) >= 1003000) {
            $cObjData = $this->configurationManager->getContentObject()->data;
        } else {
            $cObjData = $this->request->getContentObjectData();
        }
        $this->extKey = "Tp3Social";

        $this->conf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);

        $cObj = GeneralUtility::xml2array($cObjData["pi_flexform"]);
        $this->settings["layout"] = $this->settings["layout"] ? $this->settings["layout"] : "style05";
        //$this->settings["layout"] = $cObj['data']['sDEF']['lDEF']['layout']['vDEF'] ?  $cObj['data']['sDEF']['lDEF']['layout']['vDEF'] : $this->settings["layout"];
        //override settings from flexform
        if(is_array($cObj['data']['sDEF']['lDEF']))$keys = array_keys ($cObj['data']['sDEF']['lDEF']);
        if(is_array($keys))
            foreach($keys as $key){
                $this->settings[$key] = $cObj['data']['sDEF']['lDEF'][$key]['vDEF'] ?  $cObj['data']['sDEF']['lDEF'][$key]['vDEF'] : $this->settings[$key];
            }
        $this->cObjRenderer =$this->objectManager->get('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');

        $this->pageRenderer =  $this->objectManager->get('TYPO3\\CMS\\Core\\Page\\PageRenderer');
        $this->view->assign('cObjData', $cObj);
    }

}
