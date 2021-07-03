<?php

namespace App\Controller;

use App\Entity\Citas;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("email/{template}/{cita}",name="mail")
     */
    public function Email($template, $cita, MailerInterface $mailer)
    {
        $em = $this->getDoctrine()->getManager();
        $c = $em->getRepository(Citas::class)->find($cita);
        $email = (new TemplatedEmail())
            ->from('tribecca@noreply.com')
            ->to('gelymontero07@gmail.com')
            ->subject('Cita')
            ->htmlTemplate('email/' . $template . '.html.twig')
            ->context([
                'cita' => $c
            ]);
        $mailer->send($email);
        return $this->redirectToRoute('home');
    }
}
