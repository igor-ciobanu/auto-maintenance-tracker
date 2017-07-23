<?php

namespace API\Service\SqlSpec;

use API\RequestModel\CarType;
use Core\Specification\SqlSpecificationInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class RoleListFilter
 * @package API\Service\SqlSpec
 */
class CarTypeListFilter implements SqlSpecificationInterface
{
    private $filter = null;

    public function __construct(CarType $filter)
    {
        $this->filter = $filter;
    }

    public function specify(QueryBuilder $query)
    {
        $query->select('ct')
            ->from('Core\Entity\CarType', 'ct');
        if ($this->filter->type) {
            $query->where("ct.type = :type");
            $query->setParameter('type', $this->filter->type);
        }
        $query->orderBy('ct.type', 'ASC');
    }
}
