<?php

namespace App\Controller;

use App\Entity\Facturas;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FacturaController extends AbstractController
{
    /**
     * @Route("/facturas", name="misfacturas")
     */
    public function index(PaginatorInterface $paginator,Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $facturas = $em->getRepository(Facturas::class)->FacturasCompletasporUsuario($user);
        $pagination = $paginator->paginate(
            $facturas, /* query NOT result */
            $request->query->getInt('pagina', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('factura/index.html.twig', [
            'query' => $pagination
        ]);
    }
}
