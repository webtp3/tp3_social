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
		\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( $key, $this->extKey);
	}
	/**
	 *
	 * @var \TYPO3\CMS\Core\Page\PageRenderer;
	 */
	
	public $pageRenderer;
    /**
     *
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
     */
    public  $settings;

	/**
	 *
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
	 */
	public  $cObj;
    /**
     * getShares
     * 
     * @return Shares
     */
    public function getShares($cObj,$settings)
    {

    	
    	$this->setDefaultViewVars();
        $this->settings = $settings;

       $lang_short = $GLOBALS['TSFE']->tmpl->setup['config.']['language'];
    	$lang_big 	= $GLOBALS['TSFE']->tmpl->setup['config.']['locale_all'];
        $this->cObj = GeneralUtility::xml2array($cObj["pi_flexform"]);

        $this->layout = $this->cObj['data']['sDEF']['lDEF']['layout']['vDEF'] ?  $this->cObj['data']['sDEF']['lDEF']['layout']['vDEF'] : $this->layout;
        //override settings from flexform
        $keys = array_keys ($this->cObj['data']['sDEF']['lDEF']);
        foreach($keys as $key){
              $this->settings[$key] = $this->cObj['data']['sDEF']['lDEF'][$key]['vDEF'] ?  $this->cObj['data']['sDEF']['lDEF'][$key]['vDEF'] : $this->settings[$key];
        }

        if(!empty($lang_big)) {
    		$lang_big = explode('.', $lang_big);
    		$lang_big = $lang_big['0'];
    	}

    	$output = '';
    	$error	= '';
    	
    	$vars = 'twitter,facebook,google,meinvz,youtube,xing,linkedin,tumblr,vkontakte,flickr,googleshare,t3n,twittername,youtubename,flickrname,BITusername,BITapi,layout,shortener,sorting,facebookid,googleid';
    	//foreach (explode(',', $vars) as $value) $$value = ($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3social_tp3share.'][$value]) ? $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_tp3social_tp3share.'][$value] : $this->cObj->data['pi_flexform']['data']['sDEF']['lDEF'][$value]['vDEF'] ;
    	$pagetitle 		= $GLOBALS['TSFE']->page['subtitle'] ? $GLOBALS['TSFE']->page['subtitle']: $GLOBALS['TSFE']->page['title'];
    	$realurl 		= 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    	
    	# - bitly
    	if($shortener == 'bitly') {
    		$error .= (!$BITusername || $BITusername == '') ? $this->gettranslation('error_bit_username').'<br />' : '' ;
    		$error .= (!$BITapi || $BITapi == '') 			? $this->gettranslation('error_bit_api').'<br />' 		: '' ;
    		if($error == '') $biturl =  $this->make_bitly_url($realurl,$BITusername,$BITapi,'json');
    	}

        $this->pageRenderer->addCssFile(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath( $this->extKey ).'Resources/Public/Css/'.$this->layout.'/style.css');
    	
    	 
    	# - username error
    	if($youtube == 1 && $youtubename == '') $error .= $this->gettranslation('error_youtubename').'<br />';
    	
    	# - language
    	$error .= (empty($lang_short)) 	? $this->gettranslation('error_language').'<br />' 	: '' ;
    	$error .= (empty($lang_big)) 	? $this->gettranslation('error_locale_all').'<br />' 	: '' ;
    	
    	# - error return
    	if($error !='') return $error;
    	
    	$theurl = ($shortener == 'bitly') ? $biturl : $realurl ;
    	
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
    	if($this->settings["twitter"] == 1 && in_array($this->layout, explode(',', $twitter_button))) {
    		$thelenght = 140-strlen($twittername)-35;
    		$parameters= $thelenght.'|...|true';
    		$posttitle = $this->cObj->crop($pagetitle,$parameters);
    		$twitterlink =  'https://twitter.com/share?original_referer='.$theurl.'&text='.urlencode($posttitle.' @'.$twittername);
    		$twitter_output = '<a title="Twitter" class="twitter '.$this->layout.'" target="_blank" href="'.$twitterlink.'">Twitter</a>';
    		$this->pageRenderer->addJsFooterInlineCode($this->extKey."_tw",'!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");');
    		
    	}
    	
    	#- facebook
    	if($this->settings["facebook"] == 1 && in_array($this->layout, explode(',', $facebook_button))) {
    		$facebooklink = 'https://www.facebook.com/sharer.php?u='.urlencode($theurl);
    		$facebook_output = '<a title="Facebook" class="facebook '.$this->layout.'" target="_blank" href="'.$facebooklink.'">Facebook</a>';
    		$this->pageRenderer->addJsFooterInlineCode($this->extKey."_fb",'(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/'.$lang_big.'/all.js#xfbml=1&appId='.$this->settings["facebookid"].'";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));');
    	}
    	
    	# - meinvz
    	if($this->settings["meinvz"] == 1 && in_array($this->layout, explode(',', $meinvz_button))) {
    		$parameters= '80|...|true';
    		$posttitle = $this->cObj->crop($pagetitle,$parameters);
    		$meinvzlink = '//www.studivz.net/Suggest/Selection/?u='.urlencode($theurl).'&desc='.urlencode($posttitle).'&prov='.$_SERVER['SERVER_NAME'];
    		$meinvz_output = '<a title="meinVZ" class="meinvz '.$this->layout.'" target="_blank" href="'.$meinvzlink.'">meinVZ</a>';
    	}
    	
    	# - xing
    	if($this->settings["xing"] == 1 && in_array($this->layout, explode(',', $xing_button))) {
    		$xinglink = '//www.xing.com/app/user?op=share;url='.urlencode($theurl).';title='.urlencode($pagetitle);
    		$xing_output = '<a title="Xing" class="xing '.$this->layout.'" target="_blank" href="'.$xinglink.'">Xing</a>';
    	}
    	
    	# - linkedin
    	if($this->settings["linkedin"] == 1 && in_array($this->layout, explode(',', $linkedin_button))) {
    		$linkedinlink = '//www.linkedin.com/shareArticle?mini=true&url='.urlencode($theurl);
    		$linkedin_output = '<a title="LinkedIn" class="linkedin '.$this->layout.'" target="_blank" href="'.$linkedinlink.'">LinkedIn</a>';
    	}
    	
    	#- youtube
    	if($this->settings["youtube"] == 1 && in_array($this->layout, explode(',', $youtube_button))) {
    		$youtube_output = '<a title="YouTube" class="youtube '.$this->layout.'" target="_blank" href="http://www.youtube.com/user/'.$youtubename.'">YouTube</a>';
    	}
    	
    	#- tumblr
    	if($this->settings["tumblr"] == 1 && in_array($this->layout, explode(',', $tumblr_button))) {
    		$this->pageRenderer->addFooterData('<script src="http://platform.tumblr.com/v1/share.js"></script>');
    		
    		$tumblr_output = '<a title="Tumblr" class="tumblr '.$this->layout.'" target="_blank" href="http://www.tumblr.com/share/link?url='.urlencode($theurl).'&name='.urlencode($posttitle).'">Tumblr</a>';
    	}
    	
    	#- vkontakte
    	if($this->settings["vkontakte"] == 1 && in_array($this->layout, explode(',', $vkontakte_button))) {
    		$vkontakte_output = '<a title="VKontakte" class="vkontakte '.$this->layout.'" target="_blank" href="http://vk.com/share.php?url='.urlencode($theurl).'">VKontakte</a>';
    	}
    	
    	#- flickr
    	if($this->settings["flickr"] == 1 && in_array($this->layout, explode(',', $flickr_button))) {
    		$flickr_output = '<a title="Flickr" class="flickr '.$this->layout.'" target="_blank" href="'.$flickrname.'">Flickr</a>';
    	}
    	/*if($this->settings["google"] == 1) {
    	 $boxpos = 'medium';
    	 $this->pageRenderer->addFooterData('<script src="//apis.google.com/js/plusone.js?publisherid='.$this->settings["googleid"].'"></script>');
    	 $googleplus_output = '<a class="st_socialnetwork_g_'.$this->layout.'"><div class="g-plusone" data-size="'.$boxpos.'"></div></div>';
    	 }*/
    	if($this->settings["google"] == 1) {
    	 $boxpos = 'vertical-bubble' ;
    	 $googleshare_output = '<a class="g-plus" data-action="share" data-annotation="'.$boxpos.'"></a>';
    	 $this->pageRenderer->addJsFooterInlineCode($this->extKey."_gg",'window.___gcfg = {lang: \''.$lang_short.'\'};
    	 (function() {
    	 var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
    	 po.src = \'//apis.google.com/js/plusone.js?publisherid='.$this->settings["googleid"].'&output=embed\';
    	 var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
    	 })();
    	 ');
    	 }
    	//# - style11 and style 12
    	if ($this->layout == 'style11' || $this->layout == 'style12' ) {
    		$output = '';
    		if($this->settings["twitter"] == 1) {
    			$boxpos = ($this->layout == 'style11') ? 'horizontal' : 'vertical' ;
    			$twitter_output = '<div class="st_socialnetwork_t_'.$this->layout.'"><a href="https://twitter.com/share" class="twitter-share-button" data-count="'.$boxpos.'" data-via="'.$twittername.'" data-lang="'.$lang_short.'">Twittern</a></div>';
    			$this->pageRenderer->addJsFooterInlineCode($this->extKey."_tw",'!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");');
    		}
    			
    		if($this->settings["facebook"] == 1) {
    			$boxpos = ($this->layout == 'style11') ? 'button_count' : 'box_count' ;
    			$facebook_output = '<div id="fb-root"></div><div class="st_socialnetwork_f_'.$this->layout.'"><div class="fb-like" data-href="'.$realurl.'" data-send="false" data-layout="'.$boxpos.'" data-width="90" data-show-faces="true"></div></div>';
				$this->pageRenderer->addJsFooterInlineCode($this->extKey."_fb",'(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/'.$lang_big.'/all.js#xfbml=1&appId='.$this->settings["facebookid"].'";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));');
				
    		}
    			
    		if($this->settings["xing"] == 1) {
    			$boxpos = ($this->layout == 'style11') ? 'right' : 'top' ;
    			$xing_output = '<div class="st_socialnetwork_x_'.$this->layout.'"></div>';
    			$this->pageRenderer->addFooterData('<script src="//www.xing-share.com/js/external/share.js"></script>');
    			$this->pageRenderer->addFooterData('<script type="XING/Share" data-counter="'.$boxpos.'" data-lang="'.$lang_short.'" data-url="'.$realurl.'"></script>');
    		}
    			
    		if($this->settings["google"] == 1) {
    			$boxpos = ($this->layout == 'style11') ? 'medium' : 'tall' ;
    			$this->pageRenderer->addFooterData('<script src="//apis.google.com/js/plusone.js?publisherid='.$this->settings["googleid"].'">{lang: \''.$lang_short.'\'}</script>');
    			$googleplus_output = '<div class="st_socialnetwork_g_'.$this->layout.'"><div class="g-plusone" data-size="'.$boxpos.'"></div></div>';
    		}
    	
    		if($this->settings["linkedin"] == 1) {
    			$boxpos = ($this->layout == 'style11') ? 'right' : 'top' ;
    			$this->pageRenderer->addFooterData('<script src="//platform.linkedin.com/in.js" type="text/javascript"></script><script type="IN/Share" data-url="'.$realurl.'" data-counter="'.$boxpos.'"></script>');
    			$linkedin_output = '';
    		}
    	
    		if($this->settings["googleshare"] == 1) {
    		 $boxpos = ($this->layout == 'style11') ? 'bubble' : 'vertical-bubble' ;
    		 $googleshare_output = '<div class="g-plus" data-action="share" data-annotation="'.$boxpos.'"></div>';
    		 $this->pageRenderer->addJsFooterInlineCode($this->extKey."_fb",'window.___gcfg = {lang: \''.$lang_short.'\'};
		    		 (function() {
		    		 var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
		    		 po.src = \'//apis.google.com/js/plusone.js?publisherid='.$this->settings["googleid"].'&output=embed\';
		    		 var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
		    		 })();');
    		 }
    	
    		if($this->settings["t3n"] == 1) {
    			$boxpos = ($this->layout == 'style11') ? '' : '?count=vertical' ;
    			$this->pageRenderer->addFooterData('<script type="text/javascript" src="http://t3n.de/aggregator/ebutton/'.$boxpos.'"></script>');
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
     * This method assigns some default variables to the view
     */
    private function setDefaultViewVars() {

        $this->extKey = "Tp3Social";
    	$this->layout = $this->settings["layout"] ? $this->settings["layout"] : "style05";
    	//$this->cObj = GeneralUtility::makeInstance(TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer);
    	$this->pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Page\\PageRenderer');
    	//$this->view->assign('cObjData', $cObjData);
    }
    
}
