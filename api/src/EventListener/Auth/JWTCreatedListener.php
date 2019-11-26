<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 26.11.19
 * Time: 9:20
 */

namespace App\EventListener\Auth;

use App\Entity\User\User;
use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack, EntityManager $entityManager)
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        $payload = $event->getData();
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $event->getUser()->getUsername()]);
        $payload['id'] = $user->getId();

        $event->setData($payload);
    }
}