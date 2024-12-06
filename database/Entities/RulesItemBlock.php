<?php

namespace Flute\Modules\Rules\database\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\BelongsTo;

/**
 * @Entity()
 */
class RulesItemBlock
{
    /** @Column(type="primary") */
    public $id;

    /** @BelongsTo(target="RulesItem", nullable=false) */
    public $rulesItem;

    /** @Column(type="json") */
    public $json;
}