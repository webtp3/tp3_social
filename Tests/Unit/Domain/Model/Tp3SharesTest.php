<?php
namespace Tp3\Tp3Social\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Thomas Ruta <email@thomasruta.de>
 */
class Tp3SharesTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Tp3\Tp3Social\Domain\Model\Tp3Shares
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Tp3\Tp3Social\Domain\Model\Tp3Shares();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getStyleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getStyle()
        );

    }

    /**
     * @test
     */
    public function setStyleForStringSetsStyle()
    {
        $this->subject->setStyle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'style',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getTwitterReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getTwitter()
        );

    }

    /**
     * @test
     */
    public function setTwitterForBoolSetsTwitter()
    {
        $this->subject->setTwitter(true);

        self::assertAttributeEquals(
            true,
            'twitter',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getFacebookReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getFacebook()
        );

    }

    /**
     * @test
     */
    public function setFacebookForBoolSetsFacebook()
    {
        $this->subject->setFacebook(true);

        self::assertAttributeEquals(
            true,
            'facebook',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getGoogleReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getGoogle()
        );

    }

    /**
     * @test
     */
    public function setGoogleForBoolSetsGoogle()
    {
        $this->subject->setGoogle(true);

        self::assertAttributeEquals(
            true,
            'google',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getYoutubeReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getYoutube()
        );

    }

    /**
     * @test
     */
    public function setYoutubeForBoolSetsYoutube()
    {
        $this->subject->setYoutube(true);

        self::assertAttributeEquals(
            true,
            'youtube',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getXingReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getXing()
        );

    }

    /**
     * @test
     */
    public function setXingForBoolSetsXing()
    {
        $this->subject->setXing(true);

        self::assertAttributeEquals(
            true,
            'xing',
            $this->subject
        );

    }
}
