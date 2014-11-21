<?php

namespace MyApplication\Navigation;

use Joseki\LeanMapper\BaseEntity;

/**
 * @property-read int $id (descendant)
 * @property Section $ancestor
 * @property Section $descendant
 * @property int $depth
 */
class SectionClosure extends BaseEntity
{

} 
