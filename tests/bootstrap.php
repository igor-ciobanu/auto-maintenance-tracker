<?php

chdir (dirname(__DIR__));

define('ROOT_PATH', dirname(__DIR__) . '/public');

echo "Working directory: ", dirname(__DIR__),"\n";

include __DIR__ . '/../vendor/autoload.php';

\Zend\Mvc\Application::init(include 'config/application.config.php');


class TestBootstrap
{
    /**
     * @var \Zend\Mvc\Application
     */
    static $app = null;

    public static function init()
    {
        if  (null == self::$app) {
            self::$app = \Zend\Mvc\Application::init(include 'config/application.config.php');
        }
    }

    /**
     * @return \Zend\Mvc\Application
     */
    public static function app()
    {
        self::init();
        return self::$app;
    }
}

TestBootstrap::init();