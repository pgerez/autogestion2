<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Estimulo;
use App\Entity\Hospital;
use App\Entity\Incremento;
use App\Entity\Liquidacion;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LiquidacionAdminController extends CRUDController{

    public function listitemsAction(Request $request) : Response
    {
        $hospitalId = null;
        if($this->isGranted('ROLE_USER_HOSPITAL') or $this->isGranted('ROLE_HPGD')):
            $hospitalId = $this->getUser()->getHospital()->getId();
        endif;

        if($hospitalId != null or $this->isGranted('ROLE_SUPER_ADMIN') or $this->isGranted('ROLE_AUTOGESTION')):
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            $listado = $em->getRepository(Liquidacion::class)->findByIdLiquidacion($id,$hospitalId);
            $totalOs = $em->getRepository(Liquidacion::class)->findByIdLiquidacionOnlyOs($id,$hospitalId);
        else:
            $listado = [];
            $this->addFlash('sonata_flash_danger', 'No tiene hospital o permisos asignados para ver este reporte.');
        endif;
        return $this->render('liquidacion/list.html.twig', [
            'controller_name' => 'LiquidacionController',
            'listado' => $listado,
            'oss' => $totalOs,
        ]);

    }


    public function procItemsAction(Request $request) : Response
    {
        $id     = $request->get('id');
        $em     = $this->getDoctrine()->getManager();
        $items  = $em->getRepository(Liquidacion::class)->findByIdLiquidacionByEstimulo($id);
        $liquidacion = $em->getRepository(Liquidacion::class)->findOneBy(['id'=>$id]);
        foreach ($items as $item):
            $hospital = $em->getRepository(Hospital::class)->findOneBy(['id' => $item['hospital']]);
            $estimulo = new Estimulo();
            $estimulo->setHospitalId($hospital);
            $estimulo->setMonto(($item['suma'])/2);
            $estimulo->setFecha(new \DateTime());
            $estimulo->setLiquidacion($liquidacion);
            $em->persist($estimulo);
            $incremento = new Incremento();
            $incremento->setHospital($hospital);
            $incremento->setImporte(($item['suma']/2)*0.955);
            $incremento->setFecha(new \DateTime());
            $incremento->setDetalle('Liquidacion con ID: '.$liquidacion->getId().' y fecha: '.$liquidacion->getFechaDesde()->format('d-m-Y').' | '.$liquidacion->getFechaHasta()->format('d-m-Y'));
            $em->persist($incremento);
            $em->flush();
        endforeach;

        $this->addFlash('sonata_flash_success', 'Se crearon exitosamente los estimulos!.');

        return $this->redirectToRoute('admin_app_liquidacion_list');

    }

}
