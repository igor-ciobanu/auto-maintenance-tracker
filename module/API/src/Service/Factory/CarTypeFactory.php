<?php

namespace API\Service\Factory;

use API\Service\CarType;
use Interop\Container\ContainerInterface;

class CarTypeFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new CarType($entityManager, new \API\Service\Validator\CarType());
    }
}
