<?PHP
namespace App\Event;

use App\Entity\NewsletterEmail;


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
