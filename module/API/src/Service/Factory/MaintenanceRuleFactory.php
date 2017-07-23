<?php

namespace API\Service\Factory;

use API\Service\MaintenanceRule;
use Interop\Container\ContainerInterface;

class MaintenanceRuleFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new MaintenanceRule($entityManager, new \API\Service\Validator\MaintenanceRule());
    }
}
