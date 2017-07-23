<?php

namespace API\Service\Factory;

use API\Service\MaintenanceHistory;
use Interop\Container\ContainerInterface;

class MaintenanceHistoryFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new MaintenanceHistory($entityManager, new \API\Service\Validator\MaintenanceHistory());
    }
}
