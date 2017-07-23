<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 20/07/17
 * Time: 8:00 AM
 */

namespace API\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use API\Controller\Model as ModelController;

class ModelFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $markService = $container->get(\API\Service\Model::class);
        return new ModelController($markService);
    }
}
