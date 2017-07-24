<?php

namespace API\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use API\Controller\MaintenanceType as MaintenanceTypeController;

class MaintenanceTypeFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $markService = $container->get(\API\Service\MaintenanceType::class);
        return new MaintenanceTypeController($markService);
    }
}
