<?php

namespace API\Controller\View\ViewEntity;

use Core\Entity\Model as ModelEntity;
use API\Helper\Url;
use Hal\Resource as HalResource;

class Model
{
    /**
     * @param ModelEntity $model
     * @return array
     */
    public static function generateEntity(ModelEntity $model, $isObject = false)
    {
        $resource = new HalResource(Url::siteURL() . Url::API_MODEL_URL .'/' . $model->getId());
        $resource->setData(self::getContent($model));
        if ($model->getMark()) {
            $resource->setEmbedded('mark', Mark::generateEntity($model->getMark(), true), true);
        }
        if (true === $isObject) {
            return $resource;
        }
        return $resource->toArray();
    }

    private static function getContent(ModelEntity $model)
    {
        return [
            'id' => $model->getId(),
            'name' => $model->getName(),
        ];
    }
}
