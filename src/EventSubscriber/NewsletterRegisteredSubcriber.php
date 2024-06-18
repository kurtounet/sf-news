<?php

namespace App\EventSubscriber;

use App\Event\NewsletterRegisteredEvent;
use App\Newsletter\EmailNotification;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NewsletterRegisteredSubcriber implements EventSubscriberInterface
{
    public function __construct(
        private EmailNotification $emailNotification
    ) {

    }
    public function sendEmail(NewsletterRegisteredEvent $event): void
    {
        $this->emailNotification->sendConfirmationEmail($event->getEmail());
    }

    public static function getSubscribedEvents(): array
    {
        return [
                'NewsletterRegisteredEvent'::NAME => 'sendEmail',
        ];
    }
}
