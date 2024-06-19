<?php

namespace App\Controller;

use App\Entity\NewsletterEmail;
use App\Event\NewsletterRegisteredEvent;
use App\Form\NewsletterType;
use App\Service\SpamCheckerApi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter/subscribe', name: 'newsletter_subscribe')]
    public function subscribe(
        Request $request,
        EntityManagerInterface $em,
        EventDispatcherInterface $dispatcher,
    ): Response {



        $newsletterEmail = new NewsletterEmail();
        $form = $this->createForm(NewsletterType::class, $newsletterEmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($newsletterEmail);
            $em->flush();

            $dispatcher->dispatch(
                new NewsletterRegisteredEvent($newsletterEmail),
                NewsletterRegisteredEvent::NAME
            );

            return $this->redirectToRoute('newsletter_thanks');
        }
        $spam = 'Spam';
        return $this->render('newsletter/subscribe.html.twig', [
            'newsletterForm' => $form,
            'spam' => $spam
        ]);
    }

    #[Route('/newsletter/thanks', name: 'newsletter_thanks')]
    public function thanks(): Response
    {
        return $this->render('newsletter/thanks.html.twig');
    }
}
