<?php

namespace API\Controller\View\ViewEntity;

use Core\Entity\Mark as MarkEntity;
use API\Helper\Url;
use Hal\Resource as HalResource;

class Mark
{
    /**
     * @param MarkEntity $mark
     * @param bool $isObject
     * @return array|HalResource
     */
    public static function generateEntity(MarkEntity $mark, $isObject = false)
    {
        $resource = new HalResource(Url::siteURL() . Url::API_MARK_URL .'/' . $mark->getId());
        $resource->setData(self::getContent($mark));
        if (true === $isObject) {
            return $resource;
        }
        return $resource->toArray();
    }

    private static function getContent(MarkEntity $mark)
    {
        return [
            'id' => $mark->getId(),
            'name' => $mark->getName(),
        ];
    }
}
