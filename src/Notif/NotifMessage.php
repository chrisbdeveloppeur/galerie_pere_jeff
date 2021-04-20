<?php


namespace App\Notif;

use App\Entity\Admin;
use Twig\Environment;

class NotifMessage
{

    /**
     * NotifMessageconstructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $renderer
     */
    private $mailer;
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }


    public function sendRegisterLink($email, $securityToken)
    {
        $mail = (new \Swift_Message('www.jacques-toupet.fr - création de votre compte administrateur'))
            ->setFrom('admin@jacquestoupet.fr')
            /**
             * Ci dessous entrez l'adresse de l'utilisateur concerné : $message->getEmail()
             */
            ->setTo($email)
            ->setBody($this->renderer->render('email/register_link.html.twig',[
                'security_token' => $securityToken,
            ]), 'text/html' );
        $this->mailer->send($mail);
    }


}