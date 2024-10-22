<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Anexoii;
use App\Entity\Mensaje;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Namshi\JOSE\Signer\OpenSSL\HS512;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\JWK;
use Jose\Component\Core\AlgorithmManagerFactory;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\Repository;

final class AnexoiiAdminController extends CRUDController{

    function caller($metodo, $json,  $verb="GET") {

        $secret = 'uwqCoDEycK3byoZQqOi0qrvLtuIcyfLMWkbGA2SbAB77Egdq5mpQngjkCCSexrek';

        $payload = [
            'iss' => "https://sisse.msalsgo.gob.ar",
            'aud' => "https://esalud.msaludsgo.gov.ar/seipa/web/api/v1",
            'iat'=>  time(),
            'exp' => time() + 15,
            'id_cliente' => "autogestion"
        ];

        $header = json_encode([
            "alg" => "HS512",
            "typ" => "JWT"
        ]);

        $header = base64_encode($header);
        $payload = json_encode($payload);
        $payload = base64_encode($payload);

        $signature = hash_hmac("sha512", $header . "." . $payload, $secret, true);
        $signature = base64_encode($signature);
        $token = $header . "." . $payload . "." . $signature;

        $head = [
            'Authorization: Bearer '.$token,
            'Content-Type: application/json',
        ];

        $ch = curl_init('https://esalud.msaludsgo.gov.ar/seipa/web/api/v1/'.$metodo);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);
        #curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        #curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        #curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
        $resp = curl_exec($ch);
        $respuesta = json_decode($resp,true);
        return $respuesta;
    }

    function buscarOsAction(Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $data1 = $request->getContent();
        #$data = str_replace('"', '', $array->{'dni'});
        $data = json_decode($data1);
        $resultado = $this->caller("coberturas?dni=".$data->dni."&sexo=".$data->sexo,"GET");

        foreach ($resultado as $i => $r):
            if($resultado['statusCode'] == 200):
                if($i == 'data'):
                    $rnos['texto'] = '';
                    foreach ($resultado['data'] as $item):
                            $os = $em->getRepository('App\Entity\ObrasSociales')->findByRnos($item['rnos']);
                            if($os):
                                $rnos['osid'] = $os->getRowId();
                            else:
                                $rnos['osid'] = 0;
                            endif;
                            $rnos[$item['rnos']] = $item['cobertura'];
                            $rnos['texto'] = $rnos['texto'].' | '.$item['rnos'].' - '.$item['cobertura'];
                    endforeach;
                endif;
            else:
                $rnos['texto'] = 'No se encuentra la Obra Social de la persona.';
                $rnos['osid'] = 0;
            endif;
        endforeach;

        return new JsonResponse($rnos);
    }

    function renaperAction(Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $data1 = $request->getContent();
        #$data = str_replace('"', '', $array->{'dni'});
        $data = json_decode($data1);
        $resultado = $this->caller("renaper?dni=".$data->dni."&sexo=".$data->sexo,"GET");
        foreach ($resultado as $i => $r):
            if($resultado['statusCode'] == 200):
                if($i == 'data'):
                    $renaper['texto'] = '';
                    foreach ($resultado['data'] as $ri => $item):
                            $renaper['apellido'] =  $item['apellido'];
                            $renaper['nombres'] = $item['nombres'];
                            $renaper['texto'] = $renaper['apellido'].' '.$renaper['nombres'];
                    endforeach;
                endif;
            else:
                $renaper['texto'] = 'No se encontró el nombre de la persona.';
                $renaper['nombres'] = 0;
                $renaper['apellido'] = 0;
            endif;
        endforeach;
        return new JsonResponse($renaper);
    }


    function mensajeAction(Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $anexo_id = $request->get('id');
        $anexo = $em->getRepository(Anexoii::class)->find($anexo_id);
        $texto = $request->get('texto');
        $mensaje = new Mensaje();
        $mensaje->setFecha(new \DateTime());
        $mensaje->setTexto($texto);
        $mensaje->setAnexoii($anexo);
        $mensaje->setFosUserUserId($this->getUser());
        $em->persist($mensaje);
        $em->flush();

        #####flash exito#######
        $this->addFlash('sonata_flash_success', 'Mensaje para anexo '.$anexo_id.' guardado exitosamente!');
        return $this->redirectToRoute('admin_app_anexoii_list');
    }


}
