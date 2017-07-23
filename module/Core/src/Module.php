<?php
/**
 * Created by PhpStorm.
 * User: igorciobanu
 * Date: 1/14/17
 * Time: 11:43 AM
 */

namespace Core;

class Module
{
    const VERSION = '3.0.1';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
