<?php
namespace NS\ABCPApi\TecDocEntities;

/**
 * @method Brand[] convertToTecDocEntitiesArray($data) static
 * @method Brand createByData($data) static
 */
class Brand extends Base
{
    /**
     * Идентификатор.
     *
     * @var int
     */
    public $id;
    /**
     * Название бренда
     *
     * @var string
     */
    public $name;
}