<?php
namespace AppBundle\Service;

use Symfony\Component\Form\FormEvent;

class MailService
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * MailService constructor.
     * @param \Swift_Mailer $mailer
     * @param UserService $userService
     */
    public function __construct(\Swift_Mailer $mailer, UserService $userService)
    {
        $this->mailer = $mailer;
        $this->userService = $userService;
    }

    public function sendUserCommentNotification(FormEvent $event)
    {
        $formData = $event->getData();

        //in case of some funny business with hidden field
        if (0 === (int) $formData['user']) {
            //should return silent error
            return;
        }

        $user = $this->userService->getUser($formData['user']);

        /** @var \Swift_Message $message */
        $message = \Swift_Message::newInstance()
            ->setSubject('Congratulations! You\'ve received a comment!')
            ->setFrom('prospective_employee@clicktrans.com')
            ->setTo($user->getEmail())
            ->setBody(
                'You have received a comment! It\'s title: ' . $formData['title'],
                'text/html'
            );

        $this->mailer->send($message);
    }

}