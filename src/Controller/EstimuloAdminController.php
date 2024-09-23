<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Estimulo;
use App\Entity\Recibo;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sonata\AdminBundle\Controller\CRUDController;

final class EstimuloAdminController extends CRUDController{

    public function batchActionRecibo(ProxyQueryInterface $selectedModelQuery, Request $request): RedirectResponse
    {
        $idx    = $request->get('idx');
        $em     = $this->getDoctrine()->getManager();
        $total  = 0;
        $b      = 0;
        $stop   = false;
        foreach ($idx as $id):
            $estimulo = $em->getRepository(Estimulo::class)->find(['id' => $id]);
            $total    = $total + $estimulo->getMonto();
            if($b == 0){
                $hospital = $estimulo->getHospitalId();
                $b = 1;
            }
            if($hospital != $estimulo->getHospitalId()){
                $stop = true;
            }
        endforeach;

        if(!$stop){
            $recibo   = new Recibo();
            $recibo->setNumero($em->getRepository(Recibo::class)->findOneBy([], ['numero' => 'desc'])->getNumero()+1);
            $recibo->setMonto($total);
            $em->persist($recibo);
            $em->flush();
            $result = $em->getRepository(Estimulo::class)->updateIdRecibo($idx, $recibo->getId());
            $this->addFlash('sonata_flash_success', 'Recibo creado con exito!.');
            return $this->redirectToRoute('admin_app_recibo_list');
        }else{
            $this->addFlash('sonata_flash_error', 'Debe seleccionar estimulos de un mismo Hospital!.');
            return $this->redirectToRoute('admin_app_estimulo_list');
        }

    }


}
