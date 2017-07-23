<?php

namespace API\Service\SqlSpec;

use API\RequestModel\Car;
use Core\Specification\SqlSpecificationInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class RoleListFilter
 * @package API\Service\SqlSpec
 */
class CarListFilter implements SqlSpecificationInterface
{
    private $filter = null;

    public function __construct(Car $filter)
    {
        $this->filter = $filter;
    }

    public function specify(QueryBuilder $query)
    {
        $query->select('c')
            ->from('Core\Entity\Car', 'c')
            ->innerJoin('c.model', 'm')
            ->innerJoin('c.carType', 'ct');
        if ($this->filter->vin) {
            $query->andWhere("c.vin = :vin");
            $query->setParameter('vin', $this->filter->vin);
        }
        if ($this->filter->year) {
            $query->andWhere("c.year = :year");
            $query->setParameter('year', $this->filter->year);
        }
        if ($this->filter->km) {
            $query->andWhere("c.km = :km");
            $query->setParameter('km', $this->filter->km);
        }
        if ($this->filter->car_type_id) {
            $query->andWhere("ct.id = :car_type_id");
            $query->setParameter('car_type_id', $this->filter->car_type_id);
        }
        if ($this->filter->model_id) {
            $query->andWhere("m.id = :model_id");
            $query->setParameter('model_id', $this->filter->model_id);
        }
    }
}
