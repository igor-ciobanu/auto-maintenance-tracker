<?php

namespace API\Controller\View;

use API\Helper\Url;
use Zend\View\Model\JsonModel;
use API\Controller\View\ViewEntity\CarType as ViewEntity;
use Hal\Resource as HalResource;
use Hal\Link as HalLink;

class CarTypeCollection extends JsonModel
{

    public function __construct($carTypes)
    {
        $halResource = new HalResource($this->getEndPoint());
        $embedded = ['_embedded' => []];
        foreach ($carTypes as $item) {
            $embedded['_embedded']['carTypes'][] = ViewEntity::generateEntity($item);
        }
        $halResource->setData($embedded);
        $this->setFindLink($halResource);
        parent::__construct($halResource->toArray());
    }

    private function setFindLink(HalResource $resource)
    {
        $findLink = new HalLink($this->getEndPoint() . '{?type}', 'find');
        $findLink->setTemplated(true);
        $resource->setLink($findLink);
    }

    private function getEndPoint()
    {
        return Url::siteURL() . Url::API_CAR_TYPE_URL;
    }
}
