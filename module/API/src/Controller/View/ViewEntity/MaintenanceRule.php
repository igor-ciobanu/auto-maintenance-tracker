<?php

namespace API\Controller\View\ViewEntity;

use Core\Entity\MaintenanceRule as MaintenanceRuleEntity;
use API\Helper\Url;
use Hal\Resource as HalResource;

class MaintenanceRule
{
    /**
     * @param MaintenanceRuleEntity $maintenanceRule
     * @param bool $isObject
     * @return array|HalResource
     */
    public static function generateEntity(MaintenanceRuleEntity $maintenanceRule, $isObject = false)
    {
        $resource = new HalResource(Url::siteURL() . Url::API_MAINTENANCE_RULE_URL . '/' . $maintenanceRule->getId());
        $resource->setData(self::getContent($maintenanceRule));
        if ($maintenanceRule->getCarType()) {
            $resource->setEmbedded('carType', CarType::generateEntity($maintenanceRule->getCarType(), true), true);
        }
        if ($maintenanceRule->getMaintenanceType()) {
            $resource->setEmbedded(
                'maintenanceType',
                MaintenanceType::generateEntity($maintenanceRule->getMaintenanceType(), true),
                true
            );
        }
        if (true === $isObject) {
            return $resource;
        }
        return $resource->toArray();
    }

    private static function getContent(MaintenanceRuleEntity $maintenanceRule)
    {
        return [
            'id' => $maintenanceRule->getId(),
            'km' => $maintenanceRule->getKm(),
        ];
    }
}
