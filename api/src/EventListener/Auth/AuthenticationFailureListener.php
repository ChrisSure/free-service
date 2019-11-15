<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 14.11.19
 * Time: 15:00
 */

namespace App\EventListener\Auth;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;

/**
 * Class AuthenticationFailureListener
 * @package App\EventListener\Auth
 */
class AuthenticationFailureListener
{
    /**
     * @param AuthenticationFailureEvent $event
     */
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $data = [
            'status'  => '401 Unauthorized',
            'message' => 'You have entered mistake email or password.',
        ];

        $response = new JWTAuthenticationFailureResponse($data);

        $event->setResponse($response);
    }
}