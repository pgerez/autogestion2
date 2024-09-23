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

    public function pdfAction(Request $request) : Response
    {
        $recibo  = $this->admin->getSubject();
        $pdf = new ReportPDF('P', 'mm', 'LEGAL', true, 'UTF-8', false, false, false,false);       //set document information

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
        #$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        #$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor

        $pdf->AddPage();
        $pdf->SetFont("FreeSerif", "", 11);
        $html = <<<EOF
                <br>
                <div style="text-align: right">{$recibo->getFechaEmicion()->format('d-m-Y')}<br><strong>RECIBO {$recibo}</strong></div>
                <span style="text-align: left">
                    <strong> Departamento de Autogestion Hospitalaria</strong><br>
                    <strong> Av. Belgrano (S) N° 2050</strong><br>
                    <strong> Santiago del Estero</strong><br>
                </span>
                <br>
                <span style="text-justify: auto">
                Recibi del departamento de Autogestion Hospitalaria de la Subsecretaria de Salud Ministerio de Salud y Desarrollo Social 
                en concepto de pago de FONDO ESTIMULO conforme a lo establecido por LEY 6036/94, para ser distribuidos entre el
                Personal que cumpla con los requisitos de la reglamentacion del Dto. 712/2000 mediante expediente N° {$recibo->getExpediente()}
                Orden de Pago {$recibo->getOrdenPago()} con cargo de rendir cuenta dentro de los 10(diez) dias a contar a partir de la fecha de retiro
                de las planillas originales de acuerdo a reglamentacion vigente (Planillas firmadas,depositos de aportes, copia de informe ) informatica y reintegro de fondos
                </span>
                <br><br>
                    Liquido a Pagar: <strong>{$recibo->getMonto()}</strong>  Cheque/Transferencia:<strong> {$recibo->getCheque()}</strong><br>
                    Aporte ANSES: <strong>{$recibo->getMontoAnses()}</strong>  Cheque/Transferencia:<strong> {$recibo->getChequeAnses()}</strong><br><br>
                    
                    <div style="text-align: right">Se Entregan Planillas Originales</div><br><br>
                    <div style="text-align: right">Firma del Director y/o Responsable</div><br>
                    <div style="text-align: right">DNI:.................................</div><br><br>
                    <div style="text-align: left">{$recibo->getHospital()}</div>
                    
EOF;

        $pdf->writeHTML($html,true, false, true, false, '');
        $pdf->Output($recibo.'-recibo.pdf', 'I');
        return sfView::NONE;

    }

}
