<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Liquidacion;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LiquidacionAdminController extends CRUDController{

    public function listitemsAction(Request $request) : Response
    {
        $hospitalId = null;
        $this->isGranted('ROLE_USER_HOSPITAL') ? $hospitalId = $this->getUser()->getHospital()->getId() : '';

        if($hospitalId != null or $this->isGranted('ROLE_SUPER_ADMIN')):
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            $listado = $em->getRepository(Liquidacion::class)->findByIdLiquidacion($id,$hospitalId);
        else:
            $listado = [];
            $this->addFlash('sonata_flash_danger', 'No tiene hospital o permisos asignados para ver este reporte.');
        endif;
        return $this->render('liquidacion/list.html.twig', [
            'controller_name' => 'LiquidacionController',
            'listado' => $listado,
        ]);

    }

}
