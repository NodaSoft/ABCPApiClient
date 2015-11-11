<?php
namespace NS\ABCPApi\TecDocEntities;

/**
 * @method ModelVariant[] convertToTecDocEntitiesArray($data) static
 * @method ModelVariant createByData($data) static
 */
class ModelVariant extends Base
{
    /**
     * Идентификатор.
     *
     * @var int
     */
    public $id;
    /**
     * Название раздела.
     *
     * @var string
     */
    public $name;
    /**
     * Является ли папкой.
     *
     * @var boolean
     */
    public $hasChilds;
    /**
     * Родительский идентификатор.
     *
     * @var int
     */
    public $parentId;
}