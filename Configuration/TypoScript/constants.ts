
plugin.tx_tp3social_tp3share {
  view {
    # cat=plugin.tx_tp3social_tp3share/file; type=string; label=Path to template root (FE)
    templateRootPath = EXT:tp3_social/Resources/Private/Templates/
    # cat=plugin.tx_tp3social_tp3share/file; type=string; label=Path to template partials (FE)
    partialRootPath = EXT:tp3_social/Resources/Private/Partials/
    # cat=plugin.tx_tp3social_tp3share/file; type=string; label=Path to template layouts (FE)
    layoutRootPath = EXT:tp3_social/Resources/Private/Layouts/
  }
  persistence {
    # cat=plugin.tx_tp3social_tp3share//a; type=string; label=Default storage PID
    storagePid =
  }
  settings{
  # cat=plugin.tx_tp3social_tp3share//a; type=string; label=twitter
	  twitter 	= 1
	  # cat=plugin.tx_tp3social_tp3share//a; type=string; label=facebook
		facebook 	= 1
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=google
		google 		= 1
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=meinvz
		meinvz 		= 1
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=youtube
		youtube 	= 1
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=xing
		xing		= 1
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=linkedin
		linkedin	= 1
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=tumblr
		tumblr		= 0
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=vkontakte
		vkontakte	= 0
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=flickr
		flickr	= 0
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=twittername
		twittername = thomasruta
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=flickrname
		flickrname	= LINK TO FLICKR PHOTOSTREAM
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=youtubename
		youtubename = thomasruta
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=BITusername
		BITusername = thomnasruta
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=BITapi
		BITapi = R_666437839bbce9a5044fde7b4d39d2ff
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=layout
		layout = style11
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=googleid
		googleid ={$google_publisher}
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=googleid
		facebookid = {$facebookid}
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=shortener
		shortener = tco
		# cat=plugin.tx_tp3social_tp3share//a; type=string; label=sorting
		sorting = twitter, facebook, meinvz, youtube, tumblr, vkontakte, flickr, googleplus, googleshare, xing, linkedin, t3n
  
  }
}
