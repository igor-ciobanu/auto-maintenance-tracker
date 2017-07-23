<?php
chdir (dirname(__DIR__));

echo "Working directory: ", dirname(__DIR__),"\n";

include __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL | E_STRICT);

$bootstrap = \Zend\Mvc\Application::init(include 'config/application.config.php');

$sm = $bootstrap->getServiceManager();