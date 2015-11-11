<?php
namespace NS\ABCPApi\TecDocEntities;

/**
 * @method OENNumber[] convertToTecDocEntitiesArray($data) static
 * @method OENNumber createByData($data) static
 */
class OENNumber extends Base
{
    /**
     * Порядковый номер блока.
     *
     * @var int
     */
    public $blockNumber;
    /**
     * Название производителя (бренда)
     *
     * @var string
     */
    public $brandName;
    /**
     * Оригинальный OE-номер
     *
     * @var string
     */
    public $oeNumber;
    /**
     * Индекс сортировки.
     *
     * @var int
     */
    public $sortNumber;
}