<?php


namespace App\Transaction;


use App\Gateway\FeedbackGateway;
use App\Gateway\NotificationGateway;
use App\Gateway\UsersGateway;

class SendReplyTransaction
{
    private $notificationGateway;
    private $feedbackGateway;
    private $usersGateway;

    public function __construct(NotificationGateway $notificationGateway, FeedbackGateway $feedbackGateway, UsersGateway $usersGateway)
    {
        $this->notificationGateway = $notificationGateway;
        $this->feedbackGateway = $feedbackGateway;
        $this->usersGateway = $usersGateway;
    }

    public function notifyAdmin($receiver, $message)
    {
        $notitype = 'Send Message';
        $sender = 'Admin';
        $this->notificationGateway->insertUserreceiverType($sender, $receiver, $notitype);
        $this->feedbackGateway->insertByUserreceiverDescription($sender, $receiver, $message);
    }

    public function findAllUsers()
    {
        return $this->usersGateway->findAll();
    }
}