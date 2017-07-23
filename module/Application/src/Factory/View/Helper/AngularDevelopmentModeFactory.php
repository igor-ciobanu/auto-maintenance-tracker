<?php

namespace Application\Factory\View\Helper;

use Application\View\Helper\AngularDevelopmentModeHelper;
use Interop\Container\ContainerInterface;

class AngularDevelopmentModeFactory
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AngularDevelopmentModeHelper($container->get('configuration'));
    }
}
