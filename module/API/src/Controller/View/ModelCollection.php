<?php

namespace API\Controller\View;

use API\Helper\Url;
use Zend\View\Model\JsonModel;
use API\Controller\View\ViewEntity\Model as ViewEntity;
use Hal\Resource as HalResource;
use Hal\Link as HalLink;

class ModelCollection extends JsonModel
{
    public function __construct($models)
    {
        $halResource = new HalResource($this->getEndPoint());
        $embedded = ['_embedded' => []];
        foreach ($models as $item) {
            $embedded['_embedded']['models'][] = ViewEntity::generateEntity($item);
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
        return Url::siteURL() . Url::API_MODEL_URL;
    }
}
