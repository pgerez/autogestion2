<?php
// src/Menu/Builder.php
namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

final class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options): ItemInterface
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', ['route' => 'homepage']);

        $menu->addChild('Pago', [
            'route' => 'facturacion',
            'route' => 'liquidacion',
            #'routeParameters' => ['id' => $blog->getId()]
        ]);

        return $menu;
    }
}

