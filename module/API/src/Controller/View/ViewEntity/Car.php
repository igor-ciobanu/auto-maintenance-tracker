<?php

namespace API\Controller\View\ViewEntity;

use API\ResponseModel\Car as ResponseItem;
use API\Helper\Url;
use Hal\Resource as HalResource;

class Car
{

    public static function generateEntity(ResponseItem $item, $isObject = false)
    {
        $car = $item->car;
        $resource = new HalResource(Url::siteURL() . Url::API_CAR_URL .'/' . $car->getId());
        $resource->setData(self::getContent($item));
        if ($car->getModel()) {
            $resource->setEmbedded('model', Model::generateEntity($car->getModel(), true), true);
        }
        if ($car->getCarType()) {
            $resource->setEmbedded('carType', CarType::generateEntity($car->getCarType(), true), true);
        }
        if (true === $isObject) {
            return $resource;
        }
        return $resource->toArray();
    }

    private static function getContent(ResponseItem $item)
    {
        $car = $item->car;
        return [
            'id' => $car->getId(),
            'vin' => $car->getVin(),
            'year' => $car->getYear(),
            'km' => $car->getKm(),
            'maintenances' => $item->nextMaintenances
        ];
    }
}
