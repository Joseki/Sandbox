<?php

namespace MyApplication\Navigation;

use Joseki\LeanMapper\BaseEntity;
use Joseki\LeanMapper\ClosureTable\ISortable;

/**
 * @property int $id
 * @property string $name
 * @property string $link
 * @property Restriction[] $restrictions m:hasMany
 */
class Section extends BaseEntity implements ISortable
{

} 
