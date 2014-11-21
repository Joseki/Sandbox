<?php

namespace MyApplication\Navigation;

use Joseki\LeanMapper\ClosureTable\ClosureRepositoryTrait;
use Joseki\LeanMapper\Query;
use Joseki\LeanMapper\Repository;

/**
 * @method Section get($id)
 * @method Section findOneBy(Query $query)
 * @method Section[] findBy(Query $query)
 * @method Section[] findAll($limit = null, $offset = null)
 * @method Section[] findPageBy(Query $query, $page, $itemsPerPage)
 * @method Section[] getParent($id, $asc = true)
 * @method Section[] getChildren($id)
 * @method int findCountBy(Query $query)
 */
class SectionRepository extends Repository
{
    use ClosureRepositoryTrait;
}




