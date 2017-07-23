<?php

namespace API\Service\SqlSpec;

use API\RequestModel\MaintenanceType;
use Core\Specification\SqlSpecificationInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class RoleListFilter
 * @package API\Service\SqlSpec
 */
class LastCarMaintenance implements SqlSpecificationInterface
{
    /** @var integer  */
    private $carId;
    /** @var  integer */
    private $ruleId;

    public function __construct($carId, $ruleId)
    {
        $this->carId = $carId;
        $this->ruleId = $ruleId;
    }

    public function specify(QueryBuilder $query)
    {
        $query->select('mh')
            ->from('Core\Entity\MaintenanceHistory', 'mh')
            ->innerJoin('mh.car', 'c')
            ->innerJoin('mh.maintenanceRule', 'mr');
        if ($this->carId) {
            $query->andWhere("c.id = :car_id");
            $query->setParameter('car_id', $this->carId);
        }
        if ($this->ruleId) {
            $query->andWhere("mr.id = :ruleId");
            $query->setParameter('ruleId', $this->ruleId);
        }
        $query->orderBy('mh.id', 'DESC');
        $query->setMaxResults(1);
    }
}
