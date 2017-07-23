<?php

namespace API\Service\Factory;

use API\Service\MaintenanceType;
use Interop\Container\ContainerInterface;

class MaintenanceTypeFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new MaintenanceType($entityManager, new \API\Service\Validator\MaintenanceType());
    }
}
