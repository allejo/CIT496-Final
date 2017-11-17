<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\LoginEvent;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;

class RecordLoginSubscriber implements EventSubscriberInterface
{
    private $entityManager;
    private $requestStack;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public function onLoginSuccess(AuthenticationEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        if ($user instanceof User) {
            $request = $this->requestStack->getCurrentRequest();

            $loginEvent = new LoginEvent();
            $loginEvent
                ->setUser($user)
                ->setSuccessful(true)
                ->setIpAddress($request->getClientIp())
            ;

            $this->entityManager->persist($loginEvent);
            $this->entityManager->flush();
        }
    }

    public function onLoginFailure(AuthenticationFailureEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();
        $username = $event->getAuthenticationToken()->getUser();
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(array(
            'username' => $username,
        ));

        if ($existingUser) {
            $loginEvent = new LoginEvent();
            $loginEvent
                ->setUser($existingUser)
                ->setSuccessful(false)
                ->setIpAddress($request->getClientIp())
            ;

            $this->entityManager->persist($loginEvent);
            $this->entityManager->flush();
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            AuthenticationEvents::AUTHENTICATION_SUCCESS => 'onLoginSuccess',
            AuthenticationEvents::AUTHENTICATION_FAILURE => 'onLoginFailure',
        );
    }
}
