<?php


namespace Tests\Unit;

use Prophecy\Argument;

class DashboardTransactionTest extends \PHPUnit\Framework\TestCase
{
    private $prophet;
    private $transaction;

    private $usersGateway;
    private $feedbackGateway;
    private $notificationGateway;
    private $deletedUserGateway;

    public function setUp(): void
    {
        $this->prophet = new \Prophecy\Prophet();
        $this->gateway = $this->prophet->prophesize('Application\AdminGateway');

        $this->usersGateway = $this->prophet->prophesize('Application\Gateways\UsersGateway');
        $this->feedbackGateway = $this->prophet->prophesize('Application\Gateways\FeedbackGateway');
        $this->notificationGateway = $this->prophet->prophesize('Application\Gateways\NotificationGateway');
        $this->deletedUserGateway = $this->prophet->prophesize('Application\Gateways\DeletedUserGateway');

        $this->transaction = new \Application\Repositories\DashboardTransaction(
            $this->usersGateway->reveal(),
            $this->feedbackGateway->reveal(),
            $this->notificationGateway->reveal(),
            $this->deletedUserGateway->reveal()
        );
    }

    public function test_dashboard()
    {
        $this->usersGateway->countIds()->willReturn(2);
        $this->feedbackGateway->countByreceiver(Argument::type('string'))->willReturn(4);
        $this->notificationGateway->countByreceiver(Argument::type('string'))->willReturn(6);
        $this->deletedUserGateway->countById()->willReturn(8);

        list($bg, $regbd, $regbd2, $query) = $this->transaction->dashboard();

        $this->assertEquals(2, $bg);
        $this->assertEquals(4, $regbd);
        $this->assertEquals(6, $regbd2);
        $this->assertEquals(8, $query);
    }

    public function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }
}