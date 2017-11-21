<?php
namespace Tp3\Tp3Social\Domain\Model;

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

/**
 * Tp3Shares
 */
class Tp3Shares extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin
{
    /**
     * style
     * 
     * @var string
     */
    protected $style = '';

    /**
     * twitter
     * 
     * @var bool
     */
    protected $twitter = false;

    /**
     * facebook
     * 
     * @var bool
     */
    protected $facebook = false;

    /**
     * google
     * 
     * @var bool
     */
    protected $google = false;

    /**
     * youtube
     * 
     * @var bool
     */
    protected $youtube = false;

    /**
     * xing
     * 
     * @var bool
     */
    protected $xing = false;

    /**
     * Returns the style
     * 
     * @return string $style
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Sets the style
     * 
     * @param string $style
     * @return void
     */
    public function setStyle($style)
    {
        $this->style = $style;
    }

    /**
     * Returns the twitter
     * 
     * @return bool $twitter
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Sets the twitter
     * 
     * @param bool $twitter
     * @return void
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * Returns the boolean state of twitter
     * 
     * @return bool
     */
    public function isTwitter()
    {
        return $this->twitter;
    }

    /**
     * Returns the facebook
     * 
     * @return bool $facebook
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Sets the facebook
     * 
     * @param bool $facebook
     * @return void
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * Returns the boolean state of facebook
     * 
     * @return bool
     */
    public function isFacebook()
    {
        return $this->facebook;
    }

    /**
     * Returns the google
     * 
     * @return bool $google
     */
    public function getGoogle()
    {
        return $this->google;
    }

    /**
     * Sets the google
     * 
     * @param bool $google
     * @return void
     */
    public function setGoogle($google)
    {
        $this->google = $google;
    }

    /**
     * Returns the boolean state of google
     * 
     * @return bool
     */
    public function isGoogle()
    {
        return $this->google;
    }

    /**
     * Returns the youtube
     * 
     * @return bool $youtube
     */
    public function getYoutube()
    {
        return $this->youtube;
    }

    /**
     * Sets the youtube
     * 
     * @param bool $youtube
     * @return void
     */
    public function setYoutube($youtube)
    {
        $this->youtube = $youtube;
    }

    /**
     * Returns the boolean state of youtube
     * 
     * @return bool
     */
    public function isYoutube()
    {
        return $this->youtube;
    }

    /**
     * Returns the xing
     * 
     * @return bool $xing
     */
    public function getXing()
    {
        return $this->xing;
    }

    /**
     * Sets the xing
     * 
     * @param bool $xing
     * @return void
     */
    public function setXing($xing)
    {
        $this->xing = $xing;
    }

    /**
     * Returns the boolean state of xing
     * 
     * @return bool
     */
    public function isXing()
    {
        return $this->xing;
    }
}
