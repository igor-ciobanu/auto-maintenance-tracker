<?php

namespace API\Controller\View\ViewEntity;

use API\ResponseModel\Car as CarResponse;
use Core\Entity\MaintenanceHistory as MaintenanceHistoryEntity;
use API\Helper\Url;
use Hal\Resource as HalResource;

class MaintenanceHistory
{
    /**
     * @param MaintenanceHistoryEntity $maintenanceHistory
     * @param bool $isObject
     * @return array|HalResource
     */
    public static function generateEntity(MaintenanceHistoryEntity $maintenanceHistory, $isObject = false)
    {
        $carResponse = new CarResponse();
        $carResponse->car = $maintenanceHistory->getCar();
        $resource = new HalResource(
            Url::siteURL() . Url::API_MAINTENANCE_HISTORY_URL .'/' . $maintenanceHistory->getId()
        );
        $resource->setData(self::getContent($maintenanceHistory));
        if ($maintenanceHistory->getCar()) {
            $resource->setEmbedded('car', Car::generateEntity($carResponse, true), true);
        }
        if ($maintenanceHistory->getMaintenanceRule()) {
            $resource->setEmbedded(
                'maintenance_rule',
                MaintenanceRule::generateEntity($maintenanceHistory->getMaintenanceRule(), true),
                true
            );
        }
        if (true === $isObject) {
            return $resource;
        }
        return $resource->toArray();
    }

    private static function getContent(MaintenanceHistoryEntity $maintenanceHistory)
    {
        return [
            'id' => $maintenanceHistory->getId(),
            'km' => $maintenanceHistory->getKm(),
        ];
    }
}
