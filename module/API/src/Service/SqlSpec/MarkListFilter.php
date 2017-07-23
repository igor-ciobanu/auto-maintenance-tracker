<?php

namespace API\Service\SqlSpec;

use API\RequestModel\Mark;
use Core\Specification\SqlSpecificationInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class RoleListFilter
 * @package API\Service\SqlSpec
 */
class MarkListFilter implements SqlSpecificationInterface
{
    private $filter = null;

    public function __construct(Mark $filter)
    {
        $this->filter = $filter;
    }

    public function specify(QueryBuilder $query)
    {
        $query->select('m')
            ->from('Core\Entity\Mark', 'm');
        if ($this->filter->name) {
            $query->where("m.name = :name");
            $query->setParameter('name', $this->filter->name);
        }
        $query->orderBy('m.name', 'ASC');
    }
}
