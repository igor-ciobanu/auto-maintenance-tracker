<?php

namespace API\Controller\View\ViewEntity;

use Core\Entity\MaintenanceType as MaintenanceTypeEntity;
use API\Helper\Url;
use Hal\Resource as HalResource;

class MaintenanceType
{
    /**
     * @param MaintenanceTypeEntity $maintenanceType
     * @param bool $isObject
     * @return array|HalResource
     */
    public static function generateEntity(MaintenanceTypeEntity $maintenanceType, $isObject = false)
    {
        $resource = new HalResource(Url::siteURL() . Url::API_MAINTENANCE_TYPE_URL . '/' . $maintenanceType->getId());
        $resource->setData(self::getContent($maintenanceType));
        if (true === $isObject) {
            return $resource;
        }
        return $resource->toArray();
    }

    private static function getContent(MaintenanceTypeEntity $maintenanceType)
    {
        return [
            'id' => $maintenanceType->getId(),
            'name' => $maintenanceType->getName(),
        ];
    }
}
