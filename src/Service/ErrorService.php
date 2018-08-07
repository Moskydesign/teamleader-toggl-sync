<?php

namespace App\Service;

class ErrorService
{

    private $mailer;

    /**
     * ErrorService constructor.
     * @param $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function mail($content)
    {
        $message = (new \Swift_Message('Toggl Teamleader Sync Error'))
            ->setFrom(getenv('FROM_EMAIL'))
            ->setTo(getenv('TO_EMAIL'))
            ->setBody(
                $content,
                'text/html'
            )
        ;

        $this->mailer->send($message);

        return;
    }
}
