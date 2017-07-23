<?php

namespace API\Service\SqlSpec;

use API\RequestModel\MaintenanceType;
use Core\Specification\SqlSpecificationInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class RoleListFilter
 * @package API\Service\SqlSpec
 */
class MaintenanceTypeListFilter implements SqlSpecificationInterface
{
    private $filter = null;

    public function __construct(MaintenanceType $filter)
    {
        $this->filter = $filter;
    }

    public function specify(QueryBuilder $query)
    {
        $query->select('mt')
            ->from('Core\Entity\MaintenanceType', 'mt');
        if ($this->filter->name) {
            $query->where("mt.name = :name");
            $query->setParameter('name', $this->filter->name);
        }
        $query->orderBy('mt.name', 'ASC');
    }
}
