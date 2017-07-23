<?php

namespace API\Controller\View\ViewEntity;

use Core\Entity\CarType as CarTypeEntity;
use API\Helper\Url;
use Hal\Resource as HalResource;

class CarType
{
    /**
     * @param CarTypeEntity $carType
     * @param bool $isObject
     * @return array|HalResource
     */
    public static function generateEntity(CarTypeEntity $carType, $isObject = false)
    {
        $resource = new HalResource(Url::siteURL() . Url::API_CAR_TYPE_URL .'/' . $carType->getId());
        $resource->setData(self::getContent($carType));
        if (true === $isObject) {
            return $resource;
        }
        return $resource->toArray();
    }

    private static function getContent(CarTypeEntity $carType)
    {
        return [
            'id' => $carType->getId(),
            'type' => $carType->getType(),
        ];
    }
}
