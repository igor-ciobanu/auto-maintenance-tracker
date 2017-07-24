<?php

namespace API\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use API\Controller\MaintenanceHistory as MaintenanceHistoryController;

class MaintenanceHistoryFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $markService = $container->get(\API\Service\MaintenanceHistory::class);
        return new MaintenanceHistoryController($markService);
    }
}
