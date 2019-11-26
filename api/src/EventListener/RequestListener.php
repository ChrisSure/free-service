<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 26.11.19
 * Time: 8:16
 */

namespace App\EventListener;

use App\Exceptions\NotAllowException;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RequestListener
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        if ($event->getRequest()->server->get('HTTP_AUTHORIZATION')) {
            $userId = $this->tokenStorage->getToken()->getUser()->getId();
            if ($event->getRequest()->get('id') != $userId) {
                throw new NotAllowException('You don\'t allow this action.');
            }
        }
    }
}