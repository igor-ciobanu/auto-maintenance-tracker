<?php

namespace API\Service\SqlSpec;

use API\RequestModel\MaintenanceRule;
use Core\Specification\SqlSpecificationInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class RoleListFilter
 * @package API\Service\SqlSpec
 */
class MaintenanceRuleListFilter implements SqlSpecificationInterface
{
    private $filter = null;

    public function __construct(MaintenanceRule $filter)
    {
        $this->filter = $filter;
    }

    public function specify(QueryBuilder $query)
    {
        $query->select('mr')
            ->from('Core\Entity\MaintenanceRule', 'mr')
            ->innerJoin('mr.carType', 'ct')
            ->innerJoin('mr.maintenanceType', 'mt');
        if ($this->filter->km) {
            $query->andWhere("mt.km = :km");
            $query->setParameter('km', $this->filter->km);
        }
        if ($this->filter->car_type_id) {
            $query->andWhere("ct.id = :car_type_id");
            $query->setParameter('car_type_id', $this->filter->car_type_id);
        }
        if ($this->filter->maintenance_type_id) {
            $query->andWhere("mt.id = :maintenance_type_id");
            $query->setParameter('maintenance_type_id', $this->filter->maintenance_type_id);
        }
    }
}
