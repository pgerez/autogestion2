<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\ReportBundle\Report\ReportPDF;
use App\Entity\Estimulo;
use App\Entity\Factura;
use App\Entity\Hospital;
use App\Entity\Liquidacion;
use App\Entity\Recibo;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ReciboAdminController extends CRUDController{

    public function pdfction(Request $request) : Response
    {
        $recibo  = $this->admin->getSubject();
        $pdf = new ReportPDF('P', 'mm', 'LEGAL', true, 'UTF-8', false, false, $user,$afectacion->getTipo());       //set document information

        //$pdf = $this->get('white_october.tcpdf')->create();       //set document information

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(PDF_AUTHOR);
        $pdf->SetTitle('Recibo');

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor


        foreach ($recibo->getEstimulos() as $estimulo):

        endforeach;

        $html = <<<EOF
        
EOF;
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        return $this->redirectToRoute('admin_app_recibo_list');

    }

}
