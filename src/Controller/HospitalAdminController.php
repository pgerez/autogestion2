<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Hospital;
use App\Entity\ObrasSociales;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HospitalAdminController extends CRUDController{


    public function saldosAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository(Hospital::class)->findAllNotHpgdObject();

        return $this->render('informe/saldos.html.twig', [
            'controller_name' => 'HospitalAdminController',
            'results' => $results,
            'success' => 0,
        ]);
    }

}
