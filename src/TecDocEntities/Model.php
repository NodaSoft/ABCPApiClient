<?php
namespace NS\ABCPApi\TecDocEntities;

/**
 * @method Model[] convertToTecDocEntitiesArray($data) static
 * @method Model createByData($data) static
 */
class Model extends Base
{
    /**
     * Идентификатор модели.
     *
     * @var int
     */
    public $id;
    /**
     * Название модели.
     *
     * @var string
     */
    public $name;
    /**
     * Дата начала выпуска модели.
     *
     * @var \DateTime
     */
    public $yearFrom = null;
    /**
     * Дата окончания выпуска модели. NULL если еще выпускается.
     *
     * @var \DateTime
     */
    public $yearTo = null;

}