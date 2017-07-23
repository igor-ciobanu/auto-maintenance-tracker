<?php

namespace API\Service\Factory;

use API\Service\Car;
use Interop\Container\ContainerInterface;

class CarFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new Car($entityManager, new \API\Service\Validator\Car());
    }
}
