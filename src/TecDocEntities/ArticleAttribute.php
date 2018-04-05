<?php

namespace NS\ABCPApi\TecDocEntities;

/**
 * @method ArticleAttribute[] convertToTecDocEntitiesArray($array) static
 * @method ArticleAttribute createByData($data) static
 */
class ArticleAttribute extends Base
{
    /**
     * Идентификатор
     *
     * @var int
     */
    public $id;
    /**
     * Признак условия
     *
     * @var boolean
     */
    public $isConditional;
    /**
     * Признак интервала
     *
     * @var boolean
     */
    public $isInterval;
    /**
     * Полное название параметра
     *
     * @var string
     */
    public $name;
    /**
     * Короткое название параметра
     *
     * @var string
     */
    public $shortName;
    /**
     * Тип значения параметра (A: Буквенно-цифровой, D: Дата, К: Ключ, N: Числовой, V: Без значения
     *
     * @var string
     */
    public $type;
    /**
     * Единица измерения
     *
     * @var string
     */
    public $unit;
    /**
     * Значение
     *
     * @var string
     */
    public $value;
}