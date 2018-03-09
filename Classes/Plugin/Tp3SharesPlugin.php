<?php
namespace Tp3\Tp3Social\Plugin;

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
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Page\PageRenderer;

/**
 * Tp3SharesController
  */
class Tp3SharesPlugin extends  \TYPO3\CMS\Frontend\Plugin\AbstractPlugin
{


    /**
     *
     * @var layout;
     */

    public $layout;

	/**
	 * action translate
	 *
	 * @return string
	 */
	
	private function gettranslation($key){
		//$extensionName = "Tp3share";
		LocalizationUtility::translate( $key, $this->extKey);
	}
	/**
	 *
	 * @var \TYPO3\CMS\Core\Page\PageRenderer;
	 */
	
	public $pageRenderer = null;
    /**
     *
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
     */
    public  $cObjRenderer = null;

	/**
	 *
	 * content Object
	 */
	public  $cObj;
    /**
     * getShares
     *
     * @return Shares
     */
    public function getShares($cObj = "", $conf = "") {

        $this->conf = $conf;
        $this->cObj = $cObj;
        $this->pi_setPiVarDefaults();
        $this->pi_initPIflexForm();
        $this->ffConf = array();
        $lang_short = $GLOBALS['TSFE']->tmpl->setup['config.']['language'];
        $lang_big 	= $GLOBALS['TSFE']->tmpl->setup['config.']['locale_all'];

        if(!empty($lang_big)) {
            $lang_big = explode('.', $lang_big);
            $lang_big = $lang_big['0'];
        }

        $output = '';
        $error	= '';

        $vars = 'twitter,facebook,google,meinvz,youtube,xing,linkedin,tumblr,vkontakte,flickr,googleshare,t3n,twittername,youtubename,facebookname,googlename,flickrname,BITusername,BITapi,layout,shortener,sorting,facebookid,googleid';
        foreach (explode(',', $vars) as $value) $$value = ($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3social_tp3share.'][$value]) ? $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3social_tp3share.'][$value] : $this->cObj->data['pi_flexform']['data']['sDEF']['lDEF'][$value]['vDEF'] ;
        $pagetitle 		= $GLOBALS['TSFE']->page['subtitle'] ? $GLOBALS['TSFE']->page['subtitle']: $GLOBALS['TSFE']->page['title'];

        $realurl 		= 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $sorting =  $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3social_tp3share.']['settings.']['sorting'];
        # - bitly
        $shortener =  $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3social_tp3share.']['settings.']['shortener'];

        /*  if($shortener == 'bitly') {
              $BITusername =  $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3social_tp3share.']['settings.']['BITusername'];
               $BITapi =  $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3social_tp3share.']['settings.']['BITapi'];
              $error .= (!$BITusername || $BITusername == '') ? $this->gettranslation('error_bit_username').'<br />' : '' ;
              $error .= (!$BITapi || $BITapi == '') 			? $this->gettranslation('error_bit_api').'<br />' 		: '' ;
              if($error == '') $biturl =  $this->make_bitly_url($realurl,$BITusername,$BITapi,'json');
          }*/
       if ($this->objectManager === null) {
            $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        }
        if ($this->pageRenderer === null) {
            $this->pageRenderer = $this->objectManager->get(PageRenderer::class);
        }
        if ($this->cObjRenderer === null) {
            $this->cObjRenderer = $this->objectManager->get(ContentObjectRenderer::class);
        }
        $this->ffConf['layout'] = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'layout');
        $this->pageRenderer->addCssFile('typo3conf/ext/tp3_social/Resources/Public/Css/'.($this->ffConf['layout'] != "" ? $this->ffConf['layout'] : $this->conf["settings"]["layout"]) .'/style.css');

        //$this->response->addAdditionalHeaderData('<link href="'.\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath( $this->extKey ).'Resources/Public/Css/'.$this->settings["layout"].'/style.css" rel="stylesheet" type="text/css" />');
        $youtube =  $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3social_tp3share.']['settings.']['youtube'];
        if($youtube == 1)$youtubename =  $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3social_tp3share.']['settings.']['youtubename'];
        # - username error
        if($youtube == 1 && $youtubename == '') $error .= $this->gettranslation('error_youtubename').'<br />';

        # - language
        $error .= (empty($lang_short)) 	? $this->gettranslation('error_language').'<br />' 	: '' ;
        $error .= (empty($lang_big)) 	? $this->gettranslation('error_locale_all').'<br />' 	: '' ;

        # - error return
        if($error !='') return $error;

        // $theurl = ($shortener == 'bitly') ? $biturl : $realurl ;
        $theurl = $realurl;

        # - buttons to layout
        $twitter_button 	= 'style01,style02,style03,style04,style05,style06,style07,style08,style09,style10,style13,style14';
        $facebook_button 	= 'style01,style02,style03,style04,style05,style06,style07,style08,style09,style10,style13,style14';
        $meinvz_button 		= 'style01,style03';
        $xing_button 		= 'style01,style03,style10,style13';
        $linkedin_button 	= 'style01,style03,style04,style05,style06,style07,style08,style09,style10,style13,style14';
        $youtube_button 	= 'style02,style03,style04,style05,style06,style07,style08,style09,style10,style13,style14';
        $tumblr_button 		= 'style03,style04,style05,style13,style14';
        $vkontakte_button 	= 'style05';
        $flickr_button 		= 'style03,style04,style05,style06,style07,style13,style14';

        # - twitter
        if($this->conf["settings"]["twitter"] == 1 && in_array($this->conf["settings"]["layout"], explode(',', $twitter_button))) {
            $twittername = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3social_tp3share.']['settings.']['twittername'];
            $thelenght = 140-strlen($twittername)-35;

            $parameters= $thelenght.'|...|true';
            $posttitle = $this->cObjRenderer->crop($pagetitle,$parameters);
            $twitterlink =  'https://twitter.com/share?original_referer='.$theurl.'&text='.urlencode($posttitle.' @'.$twittername);
            $twitter_output = '<a title="Twitter" class="twitter '.$this->conf["settings"]["layout"].'" target="_blank" href="'.$twitterlink.'">Twitter</a>';
            $this->pageRenderer->addJsFooterInlineCode($this->extKey."_tw",'!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");');

        }

        #- facebook
        if($this->conf["settings"]["facebook"] == 1 && in_array($this->conf["settings"]["layout"], explode(',', $facebook_button))) {
            //   $facebooklink = 'https://www.facebook.com/feed.php?app_id='.$this->conf["settings"]["facebookid"].'&display=popup&caption='.urlencode($pagetitle).'&link='.$theurl.'&redirect_uri=https://www.facebook.com/'.$this->conf["settings"]["facebookname"];
            $facebooklink = 'https://www.facebook.com/sharer.php?u='.urlencode($theurl);
            $facebook_output = '<a title="Facebook" class="facebook '.$this->conf["settings"]["layout"].'" target="_blank" href="'.$facebooklink.'">Facebook</a>';
            $this->pageRenderer->addJsFooterInlineCode($this->extKey."_fb",'(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/'.$lang_big.'/all.js#xfbml=1&appId='.$this->conf["settings"]["facebookid"].'";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));');
        }

        # - meinvz
        if($this->conf["settings"]["meinvz"] == 1 && in_array($this->conf["settings"]["layout"], explode(',', $meinvz_button))) {
            $parameters= '80|...|true';
            $posttitle = $this->cObjRenderer->crop($pagetitle,$parameters);
            $meinvzlink = '//www.studivz.net/Suggest/Selection/?u='.urlencode($theurl).'&desc='.urlencode($posttitle).'&prov='.$_SERVER['SERVER_NAME'];
            $meinvz_output = '<a title="meinVZ" class="meinvz '.$this->conf["settings"]["layout"].'" target="_blank" href="'.$meinvzlink.'">meinVZ</a>';
        }

        # - xing
        if($this->conf["settings"]["xing"] == 1 && in_array($this->conf["settings"]["layout"], explode(',', $xing_button))) {
            $xinglink = '//www.xing.com/app/user?op=share;url='.urlencode($theurl).';title='.urlencode($pagetitle);
            $xing_output = '<a title="Xing" class="xing '.$this->conf["settings"]["layout"].'" target="_blank" href="'.$xinglink.'">Xing</a>';
        }

        # - linkedin
        if($this->conf["settings"]["linkedin"] == 1 && in_array($this->conf["settings"]["layout"], explode(',', $linkedin_button))) {
            $linkedinlink = '//www.linkedin.com/shareArticle?mini=true&url='.urlencode($theurl);
            $linkedin_output = '<a title="LinkedIn" class="linkedin '.$this->conf["settings"]["layout"].'" target="_blank" href="'.$linkedinlink.'">LinkedIn</a>';
        }

        #- youtube
        if($this->conf["settings"]["youtube"] == 1 && in_array($this->conf["settings"]["layout"], explode(',', $youtube_button))) {
            $youtube_output = '<a title="YouTube" class="youtube '.$this->conf["settings"]["layout"].'" target="_blank" href="http://www.youtube.com/user/'.$youtubename.'">YouTube</a>';
        }

        #- tumblr
        if($this->conf["settings"]["tumblr"] == 1 && in_array($this->conf["settings"]["layout"], explode(',', $tumblr_button))) {
            $this->pageRenderer->addFooterData('<script src="http://platform.tumblr.com/v1/share.js"></script>');

            $tumblr_output = '<a title="Tumblr" class="tumblr '.$this->conf["settings"]["layout"].'" target="_blank" href="http://www.tumblr.com/share/link?url='.urlencode($theurl).'&name='.urlencode($posttitle).'">Tumblr</a>';
        }

        #- vkontakte
        if($this->conf["settings"]["vkontakte"] == 1 && in_array($this->conf["settings"]["layout"], explode(',', $vkontakte_button))) {
            $vkontakte_output = '<a title="VKontakte" class="vkontakte '.$this->conf["settings"]["layout"].'" target="_blank" href="http://vk.com/share.php?url='.urlencode($theurl).'">VKontakte</a>';
        }

        #- flickr
        if($this->conf["settings"]["flickr"] == 1 && in_array($this->conf["settings"]["layout"], explode(',', $flickr_button))) {
            $flickr_output = '<a title="Flickr" class="flickr '.$this->conf["settings"]["layout"].'" target="_blank" href="'.$flickrname.'">Flickr</a>';
        }
        if($this->conf["settings"]["google"] == 1) {
            $boxpos = 'medium';
            $this->pageRenderer->addFooterData('<script src="//apis.google.com/js/plusone.js?publisherid='.$this->conf["settings"]["googleid"].'"></script>');
            $googleplus_output = '<a class="st_socialnetwork_g_'.$this->conf["settings"]["layout"].'"><div class="g-plusone" data-size="'.$boxpos.'"></div></div>';
        }

        //# - style11 and style 12
        if ($this->conf["settings"]["layout"] == 'style11' || $this->conf["settings"]["layout"] == 'style12' ) {
            $output = '';
            if($this->conf["settings"]["twitter"] == 1) {
                $boxpos = ($this->conf["settings"]["layout"] == 'style11') ? 'horizontal' : 'vertical' ;
                $twitter_output = '<div class="st_socialnetwork_t_'.$this->conf["settings"]["layout"].'"><a href="https://twitter.com/share" class="twitter-share-button" data-count="'.$boxpos.'" data-via="'.$twittername.'" data-lang="'.$lang_short.'">Twittern</a></div>';
                $this->pageRenderer->addJsFooterInlineCode($this->extKey."_tw",'!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");');
            }

            if($this->conf["settings"]["facebook"] == 1) {
                $boxpos = ($this->conf["settings"]["layout"] == 'style11') ? 'button_count' : 'box_count' ;
                $facebook_output = '<div id="fb-root"></div><div class="st_socialnetwork_f_'.$this->conf["settings"]["layout"].'"><div class="fb-like" data-href="'.$realurl.'" data-send="false" data-layout="'.$boxpos.'" data-width="90" data-show-faces="true"></div></div>';
                $this->pageRenderer->addJsFooterInlineCode($this->extKey."_fb",'(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/'.$lang_big.'/all.js#xfbml=1&appId='.$this->conf["settings"]["facebookid"].'";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));');

            }

            if($this->conf["settings"]["xing"] == 1) {
                $boxpos = ($this->conf["settings"]["layout"] == 'style11') ? 'right' : 'top' ;
                $xing_output = '<div class="st_socialnetwork_x_'.$this->conf["settings"]["layout"].'"></div>';
                $this->pageRenderer->addFooterData('<script src="//www.xing-share.com/js/external/share.js"></script>');
                $this->pageRenderer->addFooterData('<script type="XING/Share" data-counter="'.$boxpos.'" data-lang="'.$lang_short.'" data-url="'.$realurl.'"></script>');
            }

            if($this->conf["settings"]["google"] == 1) {
                $boxpos = ($this->conf["settings"]["layout"] == 'style11') ? 'medium' : 'tall' ;
                $this->pageRenderer->addFooterData('<script src="//apis.google.com/js/plusone.js?publisherid='.$this->conf["settings"]["googleid"].'">{lang: \''.$lang_short.'\'}</script>');
                $googleplus_output = '<div class="st_socialnetwork_g_'.$this->conf["settings"]["layout"].'"><div class="g-plusone" data-size="'.$boxpos.'"></div></div>';
            }

            if($this->conf["settings"]["linkedin"] == 1) {
                $boxpos = ($this->conf["settings"]["layout"] == 'style11') ? 'right' : 'top' ;
                $this->pageRenderer->addFooterData('<script src="//platform.linkedin.com/in.js" type="text/javascript"></script><script type="IN/Share" data-url="'.$realurl.'" data-counter="'.$boxpos.'"></script>');
                $linkedin_output = '';
            }

            /*  if($this->conf["settings"]["googleshare"] == 1) {
                  $boxpos = ($this->conf["settings"]["layout"] == 'style11') ? 'bubble' : 'vertical-bubble' ;
                  $googleshare_output = '<div class="g-plus" data-action="share" data-annotation="'.$boxpos.'"></div>';
                  $this->pageRenderer->addJsFooterInlineCode($this->extKey."_fb",'window.___gcfg = {lang: \''.$lang_short.'\'};
                       (function() {
                       var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
                       po.src = \'//apis.google.com/js/plusone.js?publisherid='.$this->conf["settings"]["googleid"].'&output=embed\';
                       var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
                       })();');
              }*/

            if($this->conf["settings"]["t3n"] == 1) {
                $boxpos = ($this->conf["settings"]["layout"] == 'style11') ? '' : '?count=vertical' ;
                $this->pageRenderer->addFooterData('<script type="text/javascript" src="http://t3n.de/aggregator/ebutton/'.$boxpos.'"></script>');
            }

        }
        else{
            /* if($this->conf["settings"]["google"] == 1) {
                 $boxpos = 'vertical-bubble' ;
                 $googleshare_output = '<div class="g-follow" data-action="share" data-annotation="'.$boxpos.'"></div>';
                 $this->pageRenderer->addJsFooterInlineCode($this->extKey."_gg",'window.___gcfg = {lang: \''.$lang_short.'\'};
          (function() {
          var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
          po.src = \'//apis.google.com/js/plusone.js?publisherid='.$this->conf["settings"]["googleid"].'&output=embed\';
          var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
          })();
          ');
             }*/
            if($this->conf["settings"]["google"] == 1) {
                $boxpos = 'vertical-bubble' ;
                $this->pageRenderer->addFooterData('<script src="//apis.google.com/js/plusone.js?publisherid='.$this->conf["settings"]["googleid"].'">{lang: \''.$lang_short.'\'}</script>');
                $googleplus_output = '<div class="st_socialnetwork_g_'.$this->conf["settings"]["layout"].'"><div class="g-plusone" data-size="'.$boxpos.'"></div></div>';
            }
        }

        $sorting = $sorting ? $sorting : 'twitter, facebook, meinvz, youtube, tumblr, vkontakte, flickr, googleplus, googleshare, xing, linkedin, t3n';
        foreach(explode(',', $sorting) as $s) {
            $see_output = strtolower(trim($s)).'_output';
            $output .= $$see_output;
        }

        //return $output.'<div class="cleaner"></div>';

        return $output;
    }

    /**
     * getFacebook
     *
     * @return fbpage
     */
    public function getFacebook($cObj = "", $conf = "") {
        $this->conf = $conf;
        $this->cObj = $cObj;
        $this->pi_setPiVarDefaults();
        $this->pi_initPIflexForm();
        $this->ffConf = array();
        $this->templateFile = $this->cObj->fileResource($this->conf['templateFile']);

        // Check if static template and App ID is loaded
        if($this->conf['staticTemplateCheck'] != 1){
            return '<b>Please include the static template!</b>';
        } elseif(empty($this->conf['appID'])){
            return '<b>Enter your App ID in the configuration of this plugin in the Extension Manager.</b><br /><i>If you haven\'t got one, you can get an App ID here: <a href="http://developers.facebook.com/setup/" target="_blank">http://developers.facebook.com/setup/</a></i>';
        }

        // decide if plugin is configured via Flexform or TypoScript
        if ($this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'type_form') != '') {
            $mode = 'ff';
            $this->ffConf['type_form'] = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'type_form');
        } elseif ($this->conf['type_form'] != '') {
            $mode = 'ts';
            $this->ffConf['type_form'] = $this->conf['type_form'];
        } else {
            return '<b>You have to set type_form via TypoScript or Flexform!</b>';
        }

        switch($mode){
            case 'ff':
                foreach($this->cObj->data['pi_flexform']['data']['sDEF']['lDEF'] as $key => $value){
                    $this->ffConf[$key] = $value['vDEF'];
                    $this->marker['###'.strtoupper($key).'###'] = $value['vDEF'];
                }
                break;
            case 'ts':
                foreach($this->conf[$this->ffConf['type_form'].'.'] as $key => $value){
                    $this->ffConf[$key] = $value;
                    $this->marker['###'.strtoupper($key).'###'] = $value;
                }
                break;
        }

        if(!empty($this->conf['language'])){
            $this->language = $this->conf['language'];
        } elseif(empty($this->conf['language']) && !empty($GLOBALS['TSFE']->config['config']['locale_all'])) {
            $this->language = $GLOBALS['TSFE']->config['config']['locale_all'];
        } else {
            $this->language = 'en_US';
        }

        $this->marker['###LOCALE###'] = $this->language;
        $this->marker['###APP_ID###'] = $this->conf['appID'];

        // Add extra <html> tag attribute (for IE)
        if($this->ffConf['type_form'] == 'like_button' && !empty($this->ffConf['d_og_title']) && !empty($this->ffConf['d_og_type']) && !empty($this->ffConf['d_og_url']) && !empty($this->ffConf['d_og_image_url']) && !empty($this->ffConf['d_og_sitename']) && !empty($this->ffConf['d_og_description'])){
            $addData = '
				<meta property="og:title" content="'.$this->ffConf['d_og_title'].'" />
				<meta property="og:type" content="'.$this->ffConf['d_og_type'].'" />
				<meta property="og:url" content="'.$this->ffConf['d_og_url'].'" />
				<meta property="og:image" content="'.$this->ffConf['d_og_image_url'].'" />
				<meta property="og:site_name" content="'.$this->ffConf['d_og_sitename'].'" />
				<meta property="og:description" content="'.$this->ffConf['d_og_description'].'"/>
				<meta property="fb:app_id" content="'.$this->conf['appID'].'" />
			';
            if($this->conf['W3Cmode'] == 1){
                $GLOBALS['TSFE']->additionalHeaderData[$this->extKey] = '<!-- '.$addData.' -->';
            } else {
                $GLOBALS['TSFE']->additionalHeaderData[$this->extKey] = $addData;
            }
        }

        if(!empty($this->ffConf['type_form'])){
            $GLOBALS['TSFE']->additionalFooterData[$this->extKey] = '
			<div id="fb-root"></div>
			<script>
				(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/'.$this->marker['###LOCALE###'].'/sdk.js#xfbml=1&appId='.$this->marker['###APP_ID###'].'&version=v2.0";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, \'script\', \'facebook-jssdk\'));
			</script>';
        }

        switch($this->ffConf['type_form']){
            case 'activity_feed':
                $content .= $this->displayActivityFeed();
                break;
            case 'comments':
                $content .= $this->displayComments();
                break;
            case 'facepile':
                $content .= $this->displayFacepile();
                break;
            case 'like_button':
                $content .= $this->displayLikeButton();
                break;
            case 'like_box':
                $content .= $this->displayLikeBox();
                break;
            case 'recommendations':
                $content .= $this->displayRecommendations();
                break;
            case 'send_button':
                $content .= $this->displaySendButton();
                break;
            case 'subscribe_button':
                $content .= $this->displaySubscribeButton();
                break;
            case 'share_button':
                $content .= $this->displayShareButton();
                break;
            case 'embedded':
                $content .= $this->displayEmbedded();
                break;
        }

        if ($content != '') {
            if($this->conf['W3Cmode'] == 1){
                $content = '<script language="javascript" type="text/javascript">
                    //<![CDATA[
                    document.write(\''.str_replace('
                    ','',$content).'\');
                    //]]>
                    </script>';
            }
            return $this->pi_wrapInBaseClass($content);
        }
        else {
            return '';
        }
    }




    /**
     * Displays the Activity Feed.
     * http://developers.facebook.com/docs/reference/plugins/activity/
     *
     * @return	STRING	$content	...
     */
    function displayActivityFeed(){
        if($this->ffConf['a_show_in_iframe'] == 1){
            $this->templatePrefix = '_IFRAME';
        } else {
            $content = '';
        }
        $template = $this->cObj->getSubpart($this->templateFile, '###DISPLAY_ACTIVITY_FEED'.$this->templatePrefix.'###');
        $this->marker['###A_SHOW_HEADER###'] = ($this->marker['###A_SHOW_HEADER###'] == 1 ? 'true' : 'false');
        $this->marker['###A_SHOW_RECOMMENDATIONS###'] = ($this->marker['###A_SHOW_RECOMMENDATIONS###'] == 1 ? 'true' : 'false');
        $content .= $this->cObj->substituteMarkerArray($template, $this->marker);
        return $content;
    }




    /**
     * Displays the Comments box.
     * http://developers.facebook.com/docs/reference/plugins/comments/
     *
     * @return	STRING	$content	...
     */
    function displayComments(){
        $template = $this->cObj->getSubpart($this->templateFile, '###DISPLAY_COMMENTS###');
        $this->marker['###B_PUBLISH_FEED###'] = ($this->marker['###B_PUBLISH_FEED###'] == 1 ? 'true' : 'false');
        $this->marker['###B_URL###'] = \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL');
        $content = $this->cObj->substituteMarkerArray($template, $this->marker);
        return $content;
    }




    /**
     * Displays the Facepile plugin.
     * http://developers.facebook.com/docs/reference/plugins/facepile/
     *
     * @return	STRING	$content	...
     */
    function displayFacepile(){
        if($this->ffConf['c_show_in_iframe'] == 1){
            $this->templatePrefix = '_IFRAME';
        } else {
            $content = '';
        }
        $template = $this->cObj->getSubpart($this->templateFile, '###DISPLAY_FACEPILE###');
        $content = $this->cObj->substituteMarkerArray($template, $this->marker);
        return $content;
    }




    /**
     * Displays the Like button.
     * http://developers.facebook.com/docs/reference/plugins/like/
     *
     * @return	STRING	$content	...
     */
    function displayLikeButton(){
        if($this->ffConf['d_show_in_iframe'] == 1){
            $this->templatePrefix = '_IFRAME';
        } else {
            $content = '';
        }

        $template = $this->cObj->getSubpart($this->templateFile, '###DISPLAY_LIKE_BUTTON'.$this->templatePrefix.'###');
        if(!$this->marker['###D_URL###'] || (!empty($_GET['tx_ttnews']['tt_news']) && $this->ffConf['d_tt_news'] == 1)){
            $params = array();
            foreach($_GET as $param => $value){
                if (substr($param,0,2) != '__'){
                    $params[$param] = $value;
                }
            }
            $this->marker['###D_URL###'] = \TYPO3\CMS\Core\Utility\GeneralUtility::locationHeaderUrl($this->pi_getPageLink($GLOBALS['TSFE']->id,'',$params));
        }
        $this->marker['###D_SHOW_FACES###'] = ($this->marker['###D_SHOW_FACES###'] == 1 ? 'true' : 'false');
        $this->marker['###D_SHARE###'] = ($this->marker['###D_SHARE###'] == 1 ? 'true' : 'false');
        $content .= $this->cObj->substituteMarkerArray($template, $this->marker);
        return $content;
    }




    /**
     * Displays the Like Box.
     * http://developers.facebook.com/docs/reference/plugins/like-box/
     *
     * @return	STRING	$content	...
     */
    function displayLikeBox(){
        if($this->ffConf['e_show_in_iframe'] == 1){
            $this->templatePrefix = '_IFRAME';
        } else {
            $content = '';
        }
        $template = $this->cObj->getSubpart($this->templateFile, '###DISPLAY_LIKE_BOX'.$this->templatePrefix.'###');
        $this->marker['###E_SHOW_STREAM###'] = ($this->marker['###E_SHOW_STREAM###'] == 1 ? 'true' : 'false');
        $this->marker['###E_SHOW_HEADER###'] = ($this->marker['###E_SHOW_HEADER###'] == 1 ? 'true' : 'false');
        $this->marker['###E_SHOW_FACES###'] = ($this->marker['###E_SHOW_FACES###'] == 1 ? 'true' : 'false');
        $this->marker['###E_SHOW_BORDER###'] = ($this->marker['###E_SHOW_BORDER###'] == 1 ? 'true' : 'false');
        $content .= $this->cObj->substituteMarkerArray($template, $this->marker);
        return $content;
    }




    /**
     * Displays the Recommendations plugin.
     * http://developers.facebook.com/docs/reference/plugins/recommendations/
     *
     * @return	STRING	$content	...
     */
    function displayRecommendations(){
        if($this->ffConf['h_show_in_iframe'] == 1){
            $this->templatePrefix = '_IFRAME';
        } else {
            $content = '';
        }
        $template = $this->cObj->getSubpart($this->templateFile, '###DISPLAY_RECOMMENDATIONS'.$this->templatePrefix.'###');
        $this->marker['###H_SHOW_HEADER###'] = ($this->marker['###H_SHOW_HEADER###'] == 1 ? 'true' : 'false');
        $content .= $this->cObj->substituteMarkerArray($template, $this->marker);
        return $content;
    }




    /**
     * Displays the Send Button.
     * http://developers.facebook.com/docs/reference/plugins/send/
     *
     * @return	STRING	$content	...
     */
    function displaySendButton(){
        $template = $this->cObj->getSubpart($this->templateFile, '###DISPLAY_SEND_BUTTON###');
        if(!$this->marker['###I_URL##']){
            $params = array();
            foreach($_GET as $param => $value){
                if (substr($param,0,2) != '__'){
                    $params[$param] = $value;
                }
            }
            $this->marker['###I_URL###'] = \TYPO3\CMS\Core\Utility\GeneralUtility::locationHeaderUrl($this->pi_getPageLink($GLOBALS['TSFE']->id,'',$params));
        }
        $content = $this->cObj->substituteMarkerArray($template, $this->marker);
        return $content;
    }




    /**
     * Displays the Subscribe Button.
     * http://developers.facebook.com/docs/reference/plugins/subscribe/
     *
     * @return	STRING	$content	...
     */
    function displaySubscribeButton(){
        if($this->ffConf['j_show_in_iframe'] == 1){
            $this->templatePrefix = '_IFRAME';
        } else {
            $content = '';
        }
        $template = $this->cObj->getSubpart($this->templateFile, '###DISPLAY_SUBSCRIBE_BUTTON###');
        $this->marker['###J_SHOW_FACES###'] = ($this->marker['###J_SHOW_FACES###'] == 1 ? 'true' : 'false');
        $content = $this->cObj->substituteMarkerArray($template, $this->marker);
        return $content;
    }




    /**
     * Displays the Share Button.
     * http://developers.facebook.com/docs/plugins/share-button
     *
     * @return	STRING	$content	...
     */
    function displayShareButton(){
        $template = $this->cObj->getSubpart($this->templateFile, '###DISPLAY_SHARE_BUTTON###');
        $content = $this->cObj->substituteMarkerArray($template, $this->marker);
        return $content;
    }




    /**
     * Displays Embedded posts.
     * https://developers.facebook.com/docs/plugins/embedded-posts
     *
     * @return	STRING	$content	...
     */
    function displayEmbedded(){
        $template = $this->cObj->getSubpart($this->templateFile, '###DISPLAY_EMBEDDED###');
        $content = $this->cObj->substituteMarkerArray($template, $this->marker);
        return $content;
    }




    /**
     * This method assigns some default variables to the view
     */
    private function setDefaultViewVars() {

        $this->extKey = "Tp3Social";
    	$this->layout = $this->conf["settings"]["layout"] ? $this->conf["settings"]["layout"] : "style05";
    	//$this->cObj = GeneralUtility::makeInstance(TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer);
    	$this->pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Page\\PageRenderer');
    	//$this->view->assign('cObjData', $cObjData);
    }
    
}
