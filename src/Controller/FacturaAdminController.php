<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Factura;
use App\Entity\ItemPrefacturacion;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class FacturaAdminController extends CRUDController{

    public function listitemsAction(Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $data1 = $request->getContent();
        #$data = str_replace('"', '', $array->{'dni'});
        $data = json_decode($data1);
        $idfactura = $data->idfactura;
        $idpago = $data->idpago;
        $items = $em->getRepository(Factura::class)->find($idfactura)->getItemPrefacturacions();
        $html = '<table class="table table-bordered table-striped"> 
                    <tr>
                        <th>
                            <div class="icheckbox_square-blue" style="position: relative;">
                                <input type="checkbox" id="list_batch_checkbox" style="position: absolute; opacity: 0;">
                            </div>
                        </th>
                        <th>Anexo</th>
                        <th>Paciente</th>
                        <th>Servicio</th>
                        <th>Practica</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </tr>
                </thead>';
                foreach ($items as $item):
                    $html .='<tr>
                                <td class="sonata-ba-list-field sonata-ba-list-field-batch" objectid="'.$item->getId().'">
                                    <div class="icheckbox_square-blue" style="position: relative;">
                                        <input type="checkbox" name="idx[]" value="'.$item->getId().'" style="position: absolute; opacity: 0;">
                                    </div>
                                </td>
                                <td>'.$item->getNumAnexo().'</td>
                                <td>'.$item->getNumAnexo()->getApeynom().'</td>
                                <td>'.$item->getCodservFK().'</td>
                                <td>'.$item->getNomencla()->getTema().'</td>
                                <td>'.$item->getCantidad().'</td>
                                <td>'.$item->getPrecio().'</td>
                            </tr>';
                endforeach;
         $html .= <<<EOF
                 </table>
                    <script>
                            jQuery(document).ready(function ($) {
                                // Toggle individual checkboxes when the batch checkbox is changed
                                $('#list_batch_checkbox').on('ifChanged change', function () {
                                    var checkboxes = $(this)
                            .closest('table')
                            .find('td.sonata-ba-list-field-batch input[type="checkbox"], div.sonata-ba-list-field-batch input[type="checkbox"]')
                        ;

                                    if (Admin.get_config('USE_ICHECK')) {
                                        checkboxes.iCheck($(this).is(':checked') ? 'check' : 'uncheck');
                                    } else {
                                        checkboxes.prop('checked', this.checked);
                                    }
                                });

                        // Add a CSS class to rows when they are selected
                    $('td.sonata-ba-list-field-batch input[type="checkbox"], div.sonata-ba-list-field-batch input[type="checkbox"]')
                    .on('ifChanged change', function () {
                        $(this)
                        .closest('tr, div.sonata-ba-list-field-batch')
                        .toggleClass('sonata-ba-list-row-selected', $(this).is(':checked'))
                        ;
                    })
                    .trigger('ifChanged')
                    ;
                    });
                    </script> 
EOF;

        return new JsonResponse($html);
    }

    public function saveitemsAction(Request $request) : Response
    {
        return new JsonResponse('123456789');
    }



}
