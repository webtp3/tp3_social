<?php
namespace Tp3\Tp3Social\Domain\Repository;

/***
 *
 * This file is part of the "tp3_ratings" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Thomas Ruta <email@thomasruta.de>, R&P IT Consulting GmbH
 *
 ***/

/**
 * The repository for Ratingsdatas
 */
class Tp3ShareRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
	
	public function DrawShares(){
		$this->setDefaultViewVars();
		//$this->pi_loadLL();
		//$this->pi_initPIflexForm();
		$lang_short = $GLOBALS['TSFE']->tmpl->setup['config.']['language'];
		$lang_big 	= $GLOBALS['TSFE']->tmpl->setup['config.']['locale_all'];
		 
		if(!empty($lang_big)) {
			$lang_big = explode('.', $lang_big);
			$lang_big = $lang_big['0'];
		}
		 
		$output = '';
		$error	= '';
		 
		$vars = 'twitter,facebook,google,meinvz,youtube,xing,linkedin,tumblr,vkontakte,flickr,googleshare,t3n,twittername,youtubename,flickrname,BITusername,BITapi,layout,shortener,sorting,facebookid,googleid';
		foreach (explode(',', $vars) as $value) $$value = ($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_stsocialnetwork_pi1.'][$value]) ? $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_stsocialnetwork_pi1.'][$value] : $this->cObj->data['pi_flexform']['data']['sDEF']['lDEF'][$value]['vDEF'] ;
		$pagetitle 		= $GLOBALS['TSFE']->page['subtitle'] ? $GLOBALS['TSFE']->page['subtitle']: $GLOBALS['TSFE']->page['title'];
		$realurl 		= 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		 
		# - bitly
		if($shortener == 'bitly') {
			$error .= (!$BITusername || $BITusername == '') ? $this->pi_getLL('error_bit_username').'<br />' : '' ;
			$error .= (!$BITapi || $BITapi == '') 			? $this->pi_getLL('error_bit_api').'<br />' 		: '' ;
			if($error == '') $biturl =  $this->make_bitly_url($realurl,$BITusername,$BITapi,'json');
		}
		 
		$GLOBALS['TSFE']->additionalHeaderData[$this->extKey.'_'.$layout]='<link href="'.t3lib_extMgm::siteRelPath( $this->extKey ).'static/'.$layout.'/style.css" rel="stylesheet" type="text/css" />';
		 
		# - username error
		if($youtube == 1 && $youtubename == '') $error .= $this->pi_getLL('error_youtubename').'<br />';
		 
		# - language
		$error .= (empty($lang_short)) 	? $this->pi_getLL('error_language').'<br />' 	: '' ;
		$error .= (empty($lang_big)) 	? $this->pi_getLL('error_locale_all').'<br />' 	: '' ;
		 
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
		if($twitter == 1 && in_array($layout, explode(',', $twitter_button))) {
			$thelenght = 140-strlen($twittername)-35;
			$parameters= $thelenght.'|...|true';
			$posttitle = $this->cObj->crop($pagetitle,$parameters);
			$twitterlink =  'https://twitter.com/share?original_referer='.$theurl.'&text='.urlencode($posttitle.' @'.$twittername);
			$twitter_output = '<a title="Twitter" class="twitter '.$layout.'" target="_blank" href="'.$twitterlink.'">Twitter</a>';
		}
		 
		#- facebook
		if($facebook == 1 && in_array($layout, explode(',', $facebook_button))) {
            $facebooklink = 'https://www.facebook.com/feed.php?app_id='.$this->settings["facebookid"].'&display=popup&caption='.urlencode($pagetitle).'&link='.urlencode($theurl).'&redirect_uri=https://www.facebook.com'.$this->settings["facebookname"];
			$facebook_output = '<a title="Facebook" class="facebook '.$layout.'" target="_blank" href="'.$facebooklink.'">Facebook</a>';
		}
		 
		# - meinvz
		if($meinvz == 1 && in_array($layout, explode(',', $meinvz_button))) {
			$parameters= '80|...|true';
			$posttitle = $this->cObj->crop($pagetitle,$parameters);
			$meinvzlink = '//www.studivz.net/Suggest/Selection/?u='.urlencode($theurl).'&desc='.urlencode($posttitle).'&prov='.$_SERVER['SERVER_NAME'];
			$meinvz_output = '<a title="meinVZ" class="meinvz '.$layout.'" target="_blank" href="'.$meinvzlink.'">meinVZ</a>';
		}
		 
		# - xing
		if($xing == 1 && in_array($layout, explode(',', $xing_button))) {
			$xinglink = '//www.xing.com/app/user?op=share;url='.urlencode($theurl).';title='.urlencode($pagetitle);
			$xing_output = '<a title="Xing" class="xing '.$layout.'" target="_blank" href="'.$xinglink.'">Xing</a>';
		}
		 
		# - linkedin
		if($linkedin == 1 && in_array($layout, explode(',', $linkedin_button))) {
			$linkedinlink = '//www.linkedin.com/shareArticle?mini=true&url='.urlencode($theurl);
			$linkedin_output = '<a title="LinkedIn" class="linkedin '.$layout.'" target="_blank" href="'.$linkedinlink.'">LinkedIn</a>';
		}
		 
		#- youtube
		if($youtube == 1 && in_array($layout, explode(',', $youtube_button))) {
			$youtube_output = '<a title="YouTube" class="youtube '.$layout.'" target="_blank" href="http://www.youtube.com/user/'.$youtubename.'">YouTube</a>';
		}
		 
		#- tumblr
		if($tumblr == 1 && in_array($layout, explode(',', $tumblr_button))) {
			$GLOBALS['TSFE']->additionalHeaderData[$this->extKey.'_8976']	= '<script type="text/javascript" src="http://platform.tumblr.com/v1/share.js"></script>';
			$tumblr_output = '<a title="Tumblr" class="tumblr '.$layout.'" target="_blank" href="http://www.tumblr.com/share/link?url='.urlencode($theurl).'&name='.urlencode($posttitle).'">Tumblr</a>';
		}
		 
		#- vkontakte
		if($vkontakte == 1 && in_array($layout, explode(',', $vkontakte_button))) {
			$vkontakte_output = '<a title="VKontakte" class="vkontakte '.$layout.'" target="_blank" href="http://vk.com/share.php?url='.urlencode($theurl).'">VKontakte</a>';
		}
		 
		#- flickr
		if($flickr == 1 && in_array($layout, explode(',', $flickr_button))) {
			$flickr_output = '<a title="Flickr" class="flickr '.$layout.'" target="_blank" href="'.$flickrname.'">Flickr</a>';
		}
		/*if($google == 1) {
		 $boxpos = 'medium';
		 $googleplus_output = '<script type="text/javascript" src="//apis.google.com/js/plusone.js?publisherid='.$googleid.'">{lang: \''.$lang_short.'\'}</script><a class="st_socialnetwork_g_'.$layout.'"><div class="g-plusone" data-size="'.$boxpos.'"></div></div>';
		 }
		 if($google == 1) {
		 $boxpos = 'vertical-bubble' ;
		 $googleshare_output = '<a class="g-plus" data-action="share" data-annotation="'.$boxpos.'"></a>
		 <script type="text/javascript">
		 window.___gcfg = {lang: \''.$lang_short.'\'};
		  
		 (function() {
		 var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
		 po.src = \'//apis.google.com/js/plusone.js?publisherid='.$googleid.'&output=embed\';
		 var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
		 })();
		 </script>';
		 }*/
		# - style11 and style 12
		if ($layout == 'style11' || $layout == 'style12' ) {
			$output = '';
			if($twitter == 1) {
				$boxpos = ($layout == 'style11') ? 'horizontal' : 'vertical' ;
				$twitter_output = '<div class="st_socialnetwork_t_'.$layout.'"><a href="https://twitter.com/share" class="twitter-share-button" data-count="'.$boxpos.'" data-via="'.$twittername.'" data-lang="'.$lang_short.'">Twittern</a></div><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
			}
			 
			if($facebook == 1) {
				$boxpos = ($layout == 'style11') ? 'button_count' : 'box_count' ;
				$facebook_output = '
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/'.$lang_big.'/all.js#xfbml=1&appId='.$facebookid.'";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));</script>
				<div class="st_socialnetwork_f_'.$layout.'"><div class="fb-like" data-href="'.$realurl.'" data-send="false" data-layout="'.$boxpos.'" data-width="90" data-show-faces="true"></div></div>';
			}
			 
			if($xing == 1) {
				$boxpos = ($layout == 'style11') ? 'right' : 'top' ;
				$xing_output = '<div class="st_socialnetwork_x_'.$layout.'"><script type="XING/Share" data-counter="'.$boxpos.'" data-lang="'.$lang_short.'" data-url="'.$realurl.'"></script><script src="//www.xing-share.com/js/external/share.js" type="text/javascript"></script></div>';
			}
			 
			if($google == 1) {
				$boxpos = ($layout == 'style11') ? 'medium' : 'tall' ;
				$googleplus_output = '<script type="text/javascript" src="//apis.google.com/js/plusone.js?publisherid='.$googleid.'">{lang: \''.$lang_short.'\'}</script><div class="st_socialnetwork_g_'.$layout.'"><div class="g-plusone" data-size="'.$boxpos.'"></div></div>';
			}
			 
			if($linkedin == 1) {
				$boxpos = ($layout == 'style11') ? 'right' : 'top' ;
				$linkedin_output = '<script src="//platform.linkedin.com/in.js" type="text/javascript"></script><script type="IN/Share" data-url="'.$realurl.'" data-counter="'.$boxpos.'"></script>';
			}
			 
			/*if($googleshare == 1) {
			 $boxpos = ($layout == 'style11') ? 'bubble' : 'vertical-bubble' ;
			 $googleshare_output = '<div class="g-plus" data-action="share" data-annotation="'.$boxpos.'"></div>
			 <script type="text/javascript">
			 window.___gcfg = {lang: \''.$lang_short.'\'};
			  
			 (function() {
			 var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
			 po.src = \'//apis.google.com/js/plusone.js?publisherid='.$googleid.'&output=embed\';
			 var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
			 })();
			 </script>';
			 }*/
			 
			if($t3n == 1) {
				$boxpos = ($layout == 'style11') ? '' : '?count=vertical' ;
				$t3n_output = '<script type="text/javascript" src="http://t3n.de/aggregator/ebutton/'.$boxpos.'"></script>';
			}
			 
		}
		 
		$sorting = $sorting ? $sorting : 'twitter, facebook, meinvz, youtube, tumblr, vkontakte, flickr, googleplus, googleshare, xing, linkedin, t3n';
		foreach(explode(',', $sorting) as $s) {
			$see_output = strtolower(trim($s)).'_output';
			$output .= $$see_output;
		}
		 
		return $output.'<div class="cleaner"></div>';
		
	}
	private function setDefaultViewVars() {
		if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getExtensionVersion('extbase')) >= 1003000) {
			$cObjData = $this->configurationManager->getContentObject()->data;
		} else {
			$cObjData = $this->request->getContentObjectData();
		}
	
		$this->view->assign('cObjData', $cObjData);
	}
}
