<?php

namespace API\Helper;

class Url
{
    const API_CAR_URL = '/api/car';
    const API_MARK_URL = '/api/mark';
    const API_MODEL_URL = '/api/model';
    const API_CAR_TYPE_URL = '/api/car-type';
    const API_MAINTENANCE_TYPE_URL = '/api/maintenance-type';
    const API_MAINTENANCE_RULE_URL = '/api/maintenance-rule';
    const API_MAINTENANCE_HISTORY_URL = '/api/maintenance-history';


    public static function siteURL()
    {
        $protocol = ((! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ||
            (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";
        $domainName = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        return $protocol.$domainName;
    }
}
