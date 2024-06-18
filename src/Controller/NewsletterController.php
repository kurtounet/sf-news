<?php

namespace App\Controller;

use App\Entity\NewsletterEmail;
use App\Event\NewsletterRegisteredEvent;
use App\Form\NewsletterType;
use App\Newsletter\EmailNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter/subscribe', name: 'newsletter_subscribe')]
    public function subscribe(
        Request $request,
        EntityManagerInterface $em,
        EventDispatcherInterface $dispatcher
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

        return $this->render('newsletter/subscribe.html.twig', [
            'newsletterForm' => $form
        ]);
    }

    #[Route('/newsletter/thanks', name: 'newsletter_thanks')]
    public function thanks(): Response
    {
        return $this->render('newsletter/thanks.html.twig');
    }
}