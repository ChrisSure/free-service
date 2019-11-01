<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 31.10.19
 * Time: 16:25
 */

namespace App\Service\Email;


use App\Entity\User\User;

class MailService
{
    private $mailer;
    private $template;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $template)
    {
        $this->mailer = $mailer;
        $this->template = $template;
    }

    /**
     * Send check registration
     * @param User $user
     * @param string $token
     * @return void
     */
    public function sendCheckRegistration(User $user, $token): void
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('admin@example.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->template->render(
                    'emails/auth/confirm.html.twig',
                    ['id' => $user->getId(),'token' => $token]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }
}