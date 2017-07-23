<?php

namespace API\Service\SqlSpec;

use API\RequestModel\MaintenanceHistory;
use Core\Specification\SqlSpecificationInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class RoleListFilter
 * @package API\Service\SqlSpec
 */
class MaintenanceHistoryListFilter implements SqlSpecificationInterface
{
    private $filter = null;

    public function __construct(MaintenanceHistory $filter)
    {
        $this->filter = $filter;
    }

    public function specify(QueryBuilder $query)
    {
        $query->select('mh')
            ->from('Core\Entity\MaintenanceHistory', 'mh')
            ->innerJoin('mh.car', 'c')
            ->innerJoin('mh.maintenanceRule', 'mr');
        if ($this->filter->km) {
            $query->andWhere("mt.km = :km");
            $query->setParameter('km', $this->filter->km);
        }
        if ($this->filter->car_id) {
            $query->andWhere("c.id = :car_id");
            $query->setParameter('car_id', $this->filter->car_id);
        }
        if ($this->filter->maintenance_rule_id) {
            $query->andWhere("mr.id = :maintenance_rule_id");
            $query->setParameter('maintenance_rule_id', $this->filter->maintenance_rule_id);
        }
    }
}
