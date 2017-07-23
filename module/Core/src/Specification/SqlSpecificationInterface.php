<?php
/**
 * Created by PhpStorm.
 * User: iciobanu
 * Date: 1/21/15
 * Time: 11:30 AM
 */
namespace Core\Specification;

use Doctrine\ORM\QueryBuilder;

interface SqlSpecificationInterface
{
    public function specify(QueryBuilder $query);
}
