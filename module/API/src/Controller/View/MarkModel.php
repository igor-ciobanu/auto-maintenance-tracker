<?php

namespace API\Controller\View;

use API\Controller\View\ViewEntity\Mark;
use Zend\View\Model\JsonModel;
use Core\Entity\Mark as MarkEntity;

class MarkModel extends JsonModel
{
    /**
     * @param MarkEntity $mark
     */
    public function __construct($mark)
    {
        parent::__construct(Mark::generateEntity($mark));
    }
}
