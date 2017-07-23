<?php

namespace API\Service\Factory;

use API\Service\Mark;
use Interop\Container\ContainerInterface;

class MarkFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new Mark($entityManager, new \API\Service\Validator\Mark());
    }
}
