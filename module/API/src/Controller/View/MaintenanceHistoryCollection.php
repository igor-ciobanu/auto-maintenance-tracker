<?php

namespace API\Controller\View;

use API\Helper\Url;
use Zend\View\Model\JsonModel;
use API\Controller\View\ViewEntity\MaintenanceHistory as ViewEntity;
use Hal\Resource as HalResource;
use Hal\Link as HalLink;

class MaintenanceHistoryCollection extends JsonModel
{

    public function __construct($rules)
    {
        $halResource = new HalResource($this->getEndPoint());
        $embedded = ['_embedded' => []];
        foreach ($rules as $item) {
            $embedded['_embedded']['maintenanceHistories'][] = ViewEntity::generateEntity($item);
        }
        $halResource->setData($embedded);
        $this->setFindLink($halResource);
        parent::__construct($halResource->toArray());
    }

    private function setFindLink(HalResource $resource)
    {
        $findLink = new HalLink($this->getEndPoint() . '{?name}', 'find');
        $findLink->setTemplated(true);
        $resource->setLink($findLink);
    }

    private function getEndPoint()
    {
        return Url::siteURL() . Url::API_MAINTENANCE_HISTORY_URL;
    }
}
