<?php
namespace NS\ABCPApi\TecDocEntities;

/**
 * @method Manufacturer[] convertToTecDocEntitiesArray($data) static
 * @method Manufacturer createByData($data) static
 */
class Manufacturer extends Base
{
    /**
     * Идентификатор производителя
     *
     * @var int
     */
    public $id;
    /**
     * Наименование производителя (бренда)
     *
     * @var string
     */
    public $name;
}