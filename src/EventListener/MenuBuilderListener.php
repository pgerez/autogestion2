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
			
			$child->addChild('Facturacion', [
				'label' => 'Facturacion',
				'route' => 'app_facturacion',
			]);

		}
		
		
    }
}