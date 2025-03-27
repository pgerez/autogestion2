<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Estimulo;
use App\Entity\Recibo;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PagoAdminController extends CRUDController{

    function reciboAction(Request $request) : Response
    {
        $em         = $this->getDoctrine()->getManager();
        $cuotas = $this->admin->getSubject()->getCuotas();

        foreach ($cuotas as $cuota):
            $recibo   = new Recibo();
            $recibo->setNumero($em->getRepository(Recibo::class)->findOneBy([], ['numero' => 'desc'])->getNumero()+1);
            $recibo->setCuota($cuota);
            $recibo->setMonto($cuota->getTotal());
            $recibo->setObrasocial($cuota->getPago()->getObrasSocialesCodOs());
            $em->persist($recibo);
            $em->flush();
        endforeach;

        $this->addFlash('sonata_flash_success', 'Recibo para '.$cuota->getPago()->getObrasSocialesCodOs().' creado con exito!.');
        return $this->redirectToRoute('admin_app_pago_list');
    }
}
