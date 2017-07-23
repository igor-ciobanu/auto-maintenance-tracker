<?php

namespace API\Service\SqlSpec;

use API\RequestModel\Model;
use Core\Specification\SqlSpecificationInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class RoleListFilter
 * @package API\Service\SqlSpec
 */
class ModelListFilter implements SqlSpecificationInterface
{
    private $filter = null;

    public function __construct(Model $filter)
    {
        $this->filter = $filter;
    }

    public function specify(QueryBuilder $query)
    {
        $query->select('m')
            ->from('Core\Entity\Model', 'm')
            ->innerJoin('m.mark', 'mk');
        if ($this->filter->name) {
            $query->andWhere("m.name = :name");
            $query->setParameter('name', $this->filter->name);
        }
        if ($this->filter->mark_id) {
            $query->andWhere("mk.id = :mark_id");
            $query->setParameter('mark_id', $this->filter->mark_id);
        }
        $query->orderBy('m.name', 'ASC');
    }
}
