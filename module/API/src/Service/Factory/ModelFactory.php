<?php

namespace API\Service\Factory;

use API\Service\Model;
use Interop\Container\ContainerInterface;

class ModelFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new Model($entityManager, new \API\Service\Validator\Model());
    }
}
