<?php

namespace App\Controller;

use App\Entity\Servicios;
use App\Form\CitaType;
use App\Entity\Citas;
use App\Entity\Facturas;
use App\Entity\DetallesFactura;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @IsGranted("ROLE_USER")
 */
class CitaController extends AbstractController
{
    public function servicios()
    {
        $serv = [];
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository(Servicios::class);
        $p = $rep->findAll();
        for ($i = 0; $i < sizeof($p); $i++) {
            $find = $rep->find($p[$i]);
            $name = $find->getNombre();
            $price = $find->getPrecio();
            $serv[$name . '-' . $price . '€'] = $i + 1;
        }
        return $serv;
    }

    /**
     * @Route("/ver-citas", name="MisCitas")
     */
    public function verCitas(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $query = $em->getRepository(Citas::class)->CitasPendientesporUsuario($user);
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('pagina', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('cita/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/modificarcita/{id}",name="cambiarcita")
     */
    public function modificarcita($id,Request $request)
    {
        $template = 'cambiada';
        $pt = 0;
        $manager = $this->getDoctrine()->getManager();
        $cita = $manager->getRepository(Citas::class)->find($id);
        $fac = $manager->getRepository(Facturas::class)->find($cita->getFactura());
        $form = $this->createForm(CitaType::class, $cita, [
            'servicios' => $this->servicios()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $servs = $form->get('Servicios')->getData();
            $rep = $manager->getRepository(Servicios::class);
            for ($i = 0; $i < sizeof($servs); $i++) {
                $find = $rep->find($servs[$i]);
                $this->borrardetalles($fac->getId());
                $pt += $find->getPrecio();
            }
            for ($j=0;$j<sizeof($servs);$j++){
                $find = $rep->find($servs[$j]);
                $this->crearDetalles($fac,$find);
            }
            $fac->setImporteTotal($pt);
            $manager->flush();
            return $this->redirectToRoute('mail',['template'=>$template, 'cita'=>$cita->getId()]);
        }
        return $this->render('cita/formulario.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/borrandocita/{id}", name="cancelarcita")
     */
    public function cancelarcita($id)
    {
        $template = 'cancelada';
        $em = $this->getDoctrine()->getManager();
        $cita = $em->getRepository(Citas::class)->find($id);
        $facid = $cita->getFactura()->getId();
        $this->forward('App\Controller\HomeController::Email',[
            'template'=>$template,
            'cita'=>$cita->getId()
            ]);
        $this->borrardetalles($facid);
        $em->remove($cita);
        $em->flush();
        return $this->redirectToRoute('home');
    }

    public function borrardetalles($facid)
    {
        $em = $this->getDoctrine()->getManager();
        $detalles = $em->getRepository(DetallesFactura::class)->findBy(['factura' => $facid]);
        for ($i=0;$i<sizeof($detalles);$i++){
            $em->remove($detalles[$i]);
            $em->flush();
        }
    }

    /**
     * @Route("/cita", name="cita")
     */
    public function index(Request $request)
    {
        $template = 'concertada';
        $cita = new Citas();
        $form = $this->createForm(CitaType::class, $cita, [
            'servicios' => $this->servicios()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $q = $form->get('Servicios')->getData();
            $fac = $this->crearFactura($q);
            $user = $this->getUser();
            $cita->setUser($user);
            $cita->setFactura($fac);
            $manager->persist($cita);
            $manager->flush();
            return $this->redirectToRoute('mail',['template'=>$template, 'cita'=>$cita->getId()]);
        }
        return $this->render('cita/formulario.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function crearFactura($p)
    {
        $pt = 0;
        $fac = new Facturas();
        $manager = $this->getDoctrine()->getManager();
        $rep = $manager->getRepository(Servicios::class);
        for ($i = 0; $i < sizeof($p); $i++) {
            $find = $rep->find($p[$i]);
            $pt += $find->getPrecio();
        }
        $fac->setImporteTotal($pt);
        $manager->persist($fac);
        $manager->flush();
        for ($j = 0; $j < sizeof($p); $j++) {
            $serv = $rep->find($p[$j]);
            $this->crearDetalles($fac, $serv);
        }
        return $manager->getRepository(Facturas::class)->find($fac->getId());
    }

    public function crearDetalles($fac, $serv)
    {
        $det = new DetallesFactura();
        $manager = $this->getDoctrine()->getManager();
        $det->setFactura($fac);
        $det->setServicio($serv);
        $manager->persist($det);
        $manager->flush();
    }
}