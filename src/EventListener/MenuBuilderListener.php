<?php

namespace App\EventListener;

use Sonata\AdminBundle\Event\ConfigureMenuEvent;

use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class MenuBuilderListener
 * @package AdminBundle\EventListener
 */
class MenuBuilderListener
{


    protected $tokenStorage;
    protected $authenticationManager;

    public function __construct(TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
    }


    public function addMenuItems(ConfigureMenuEvent $event): void
    {
	

		$user = $this->tokenStorage->getToken()->getUser();
		$roles = $user->getRoles(); 
		
		if(in_array("ROLE_ADMIN_INFORMES", $roles)){		
			$menu = $event->getMenu();		
			
			$child = $menu->addChild('Informes', [
				'label' => 'Informes',
				//'route' => 'excel',
			])->setExtras([
				'icon' => '<i class="fa fa-file-excel-o"></i>',
			]);
			
			$child->addChild('Informe afiliados', [
				'label' => 'Informe afiliados',
				'route' => 'admin_app_afiliados_informeafil',
			]);

			$child->addChild('Informe Profesionales', [
				'label' => 'Informe Profesionales',
				'route' => 'admin_app_profesionales_informecuentacorriente',
			]);

			$child->addChild('Informe Facturacion', [
				'label' => 'Informe Facturacion',
				'route' => 'admin_app_factura_informe',
			]);
			
			$child->addChild('Profesionales Activos', [
				'label' => 'Profesionales Activos',
				'route' => 'admin_app_profesionales_informeprofact',
			]);

			$child->addChild('Informe Vencimientos', [
				'label' => 'Informe Vencimientos',
				'route' => 'admin_app_ordenprestacion_informeop',
			]);

		}
		
		
    }
}