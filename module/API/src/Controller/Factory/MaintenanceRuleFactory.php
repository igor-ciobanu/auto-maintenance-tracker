<?php

namespace API\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use API\Controller\MaintenanceRule as MaintenanceRuleController;

class MaintenanceRuleFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $markService = $container->get(\API\Service\MaintenanceRule::class);
        return new MaintenanceRuleController($markService);
    }
}
