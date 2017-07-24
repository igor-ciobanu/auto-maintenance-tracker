<?php

namespace Core\Specification;

use Doctrine\ORM\QueryBuilder;

interface SqlSpecificationInterface
{
    public function specify(QueryBuilder $query);
}
