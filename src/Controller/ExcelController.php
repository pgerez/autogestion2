<?php

namespace App\Controller;

use App\Entity\Estado;
use App\Entity\Factura;
use App\Entity\Nomencla;
use App\Entity\ObrasSociales;
use App\Entity\Hospital;
use App\Entity\Servicios;
use Afip;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController extends AbstractController
{
    /**
     * @Route("/excel", name="app_excel")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $hospitals = $em->getRepository('App\Entity\Hospital')->findAll();
        return $this->render('excel/index.html.twig', [
            'controller_name' => 'ExcelController',
            'hospitals' => $hospitals,
        ]);
    }

    /**
     * @Route("/processexcelos", name="process_excelos")
     * @return Response
     */
    public function excelos(Request $request): Response
    {
        $inputFileName = $request->files->get('excelfile');


        #$helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory to identify the format');
        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        unset($sheetData[1]);
        $sheetData = array_reverse($sheetData);

        $entityManager = $this->getDoctrine()->getManager();

        $error = false;
        foreach ($sheetData as $fila):
            if($fila['C'] != null):
                $obrasocial = $entityManager->getRepository(ObrasSociales::class)->findByRnos($fila['A']);
                if($obrasocial):
                    foreach ($obrasocial as $os):
                            $os->setCuit($fila['C']);
                            $entityManager->persist($os);
                            $entityManager->flush();
                    endforeach;
                else:
                    $error .= 'rnos no encontrado: '.$fila['A'].'<br>';
                endif;
            else:
                $error.= 'Rnos sin Cuit:'.$fila['A'].'<br>';
            endif;
        endforeach;

        if($error):
            $this->addFlash('sonata_flash_error', $error);
        endif;
        return $this->redirectToRoute('admin_app_obrassociales_list');
    }



    /**
     * @Route("/processexcel", name="process_excel")
     * @return Response
     */
    public function excel(Request $request): Response
    {
        $inputFileName = $request->files->get('excelfile');
        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        unset($sheetData[1]);
        $sheetData = array_reverse($sheetData);
        $entityManager = $this->getDoctrine()->getManager();

        $error = false;
        $em = $this->getDoctrine()->getManager();
        $estado = $em->getRepository(Estado::class)->find(1);
        $nomencla = $em->getRepository(Nomencla::class)->find(2511);
        $rnos = $entityManager->getRepository(ObrasSociales::class)->findByRnos(2808);
        foreach ($sheetData as $fila):
            $hospital = $entityManager->getRepository(Hospital::class)->findByCodigoh($fila['C']);

                    /**
                     * Creamos la Factura
                     **/
                    $factura = new Factura();
                    $factura->setCodigo(999999999);
                    $factura->setDigitalNum($fila['B']);
                    $factura->setDigitalPv(111);
                    $factura->setDigitalMonto((float)$fila['D']);
                    $factura->setMontoReal((float)$fila['D']);
                    $factura->setCae('SIN CAE');
                    $factura->setCaeVto(null);
                    $factura->setFechaEmision(\DateTime::createFromFormat('Y-m-d', $fila['A']));
                    $factura->setPeriodo(\DateTime::createFromFormat('Y-m-d', $fila['A']));
                    $factura->setUsuarioFacturacion('SISTEMA');
                    $factura->setHoraFactura(date_create('now'));
                    $factura->setMontoFact((float)$fila['D']);
                    $factura->setHospitalId($hospital);
                    $factura->setEstadoId($estado);
                    $factura->setTipoFact('C');
                    $factura->setCodOs($rnos);
                    $factura->setPuntoVenta($hospital->getPtoVta());
                    $factura->setNumeroFactura($entityManager->getRepository(Factura::class)->findById($hospital->getPtoVta())[0]['numeroFactura'] + 1);
                    $entityManager->persist($factura);
                    $entityManager->flush();
                    /**
                     * Creamos Anexoii
                     */
                    $facturaRepo = $entityManager->getRepository(Factura::class);
                    $servicioRepo = $entityManager->getRepository(Servicios::class);

                    $anexoii = new \App\Entity\Anexoii();
                    $anexoii->setTipoDoc('DNI');
                    $anexoii->setDocumento(99999999);
                    $anexoii->setApeynom('XXXX XXXXX');
                    $anexoii->setFechaNac(date_create('now'));
                    $anexoii->setSexo('M');
                    $anexoii->setCodH($hospital);
                    $anexoii->setCodOs($rnos);
                    $anexoii->setNumAfil('99999999');
                    $anexoii->setTipoBenef('Titular');
                    $anexoii->setParentesco('Otro');
                    $anexoii->setMedicos('M0468');
                    $anexoii->setMesFacturacion(date_create('now'));
                    $anexoii->setCodDev('0');
                    $anexoii->setEstadoAnexo('1');
                    $anexoii->setFechaCarga(date_create('now'));
                    $anexoii->setHoraCarga(date_create('now'));
                    $anexoii->setMes($factura->getFechaEmision()->format('m'));
                    $anexoii->setIdEntrada('34428');
                    $anexoii->setSfGuardUserId(null);
                    $entityManager->persist($anexoii);
                    $entityManager->flush();
                    /**
                     * Creamos ItmePrefacturacion
                     */
                    $itemPrefac = new \App\Entity\ItemPrefacturacion();
                    $itemPrefac->setNumAnexo($anexoii);
                    $itemPrefac->setCodservFK($servicioRepo->findOneByCodserv(269));
                    $itemPrefac->setNomencla($nomencla);
                    $itemPrefac->setCantidad(1);
                    $itemPrefac->setPrecio((string)$factura->getMontoReal());
                    $itemPrefac->setIdFacturaFK($factura);
                    $itemPrefac->setEstadoFactura(0);
                    $itemPrefac->setEstadoPago(0);
                    $itemPrefac->setEstadoItem(0);
                    $itemPrefac->setMontoPago(0);
                    $itemPrefac->setCuota(null);
                    $itemPrefac->setCodservFKM('');
                    $itemPrefac->setEstadoDebito(0);
                    $entityManager->persist($itemPrefac);
                    $entityManager->flush();

        endforeach;
        if($error):
            $this->addFlash('sonata_flash_error', $error);
        endif;
        return $this->redirectToRoute('admin_app_factura_list');

    }
}
