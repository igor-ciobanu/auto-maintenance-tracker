<?php

namespace Application\View\Helper;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;

class AngularDevelopmentModeHelper extends AbstractHelper
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function __invoke()
    {
        return $this->config['angular_development_mode'];
    }
}
