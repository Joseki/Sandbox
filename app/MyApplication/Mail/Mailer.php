<?php


namespace Services\Mail;

use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\Mail\SmtpMailer;

class Mailer
{
    private $productionMode = false;

    /** @var \Nette\Mail\SmtpMailer */
    private $smtpMailer;



    /**
     * @param SmtpMailer $smtpMailer
     * @param bool $productionMode
     */
    function __construct(SmtpMailer $smtpMailer, $productionMode)
    {
        $this->productionMode = (bool)$productionMode;
        $this->smtpMailer = $smtpMailer;
    }



    public function send(Message $message)
    {
        if ($this->productionMode) {
            $mailer = new SendmailMailer();
        } else {
            $mailer = $this->smtpMailer;
        }

        $mailer->send($message);
    }

} 
