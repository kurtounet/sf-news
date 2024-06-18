<<<<<<< HEAD
<?PHP
=======
<?php

>>>>>>> 305e96dee4b9b3e423226dbe4a7a3e1c03370fe0
namespace App\Event;

use App\Entity\NewsletterEmail;

<<<<<<< HEAD

// NewsletterRegisteredSubcriber -> php bin/console make:subscriber

class NewsletterRegisteredEvent
{
    public const NAME = 'newsletter.registered';
    public function __construct(
        private NewsletterEmail $email

    ) {

    }
    public function getEmail()
    {
        return $this->email;
    }
}
=======
class NewsletterRegisteredEvent
{
    public const NAME = 'newsletter.registered';

    public function __construct(
        private NewsletterEmail $email
    ) {
    }

    public function getEmail(): NewsletterEmail
    {
        return $this->email;
    }
}
>>>>>>> 305e96dee4b9b3e423226dbe4a7a3e1c03370fe0
