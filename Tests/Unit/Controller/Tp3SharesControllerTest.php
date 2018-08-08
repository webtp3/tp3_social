<?php
namespace Tp3\Tp3Social\Tests\Unit\Controller;


use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * Test case.
 *
 * @author Thomas Ruta <email@thomasruta.de>
 */
class Tp3SharesControllerTest extends UnitTestCase
{
    /**
     * @var \Tp3\Tp3Social\Controller\Tp3SharesController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Tp3\Tp3Social\Controller\Tp3SharesController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllTp3SharessFromRepositoryAndAssignsThemToView()
    {

        $allTp3Sharess = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $tp3SharesRepository = $this->getMockBuilder(\Tp3\Tp3Social\Domain\Repository\Tp3ShareRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $tp3SharesRepository->expects(self::once())->method('findAll')->will(self::returnValue($allTp3Sharess));
        $this->inject($this->subject, 'tp3SharesRepository', $tp3SharesRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('tp3Sharess', $allTp3Sharess);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
