<?php
namespace NS\ABCPApi\TecDocEntities;

/**
 * @method Modification[] convertToTecDocEntitiesArray($data) static
 * @method Modification createByData($data) static
 */
class Modification extends Base
{
    /**
     * Идентификатор модификации.
     *
     * @var int
     */
    public $id;
    /**
     * Название производителя, модели и модификации через пробел.
     *
     * @var string
     */
    public $name;
    /**
     * Название модификации.
     *
     * @var string
     */
    public $modificationName;
    /**
     * Идентификатор модели.
     *
     * @var int
     */
    public $modelId;
    /**
     * Название модели.
     *
     * @var string
     */
    public $modelName;
    /**
     * Идентификатор производителя (бренда)
     *
     * @var int
     */
    public $manufacturerId;
    /**
     * Название производителя (бренда).
     *
     * @var string
     */
    public $manufacturerName;
    /**
     * Дата начала выпуска модификации.
     *
     * @var \DateTime
     */
    public $yearFrom;
    /**
     * Дата окончания выпуска модификации. NULL если еще выпускается.
     *
     * @var \DateTime
     */
    public $yearTo;
    /**
     * Тип конструкции
     *
     * @var string
     */
    public $constructionType;
    /**
     * Система тормозов.
     *
     * @var string
     */
    public $brakeSystem;
    /**
     * Количество цилиндров.
     *
     * @var int
     */
    public $cylinder;
    /**
     * Объем двигателя в кубических сантиметрах.
     *
     * @var int
     */
    public $cylinderCapacityCcm;
    /**
     * Объем двигателя в литрах.
     *
     * @var string
     */
    public $cylinderCapacity;
    /**
     * Объем двигателя в сантилитрах. (в текдоке не смотря на то что поле называется Liter объем возвращается в сантилитрах)
     *
     * @var string
     */
    public $cylinderCapacityLiter;
    /**
     * Тип топлива.
     *
     * @var string
     */
    public $fuelType;
    /**
     * Система подачи топлива.
     *
     * @var string
     */
    public $fuelTypeProcess;
    /**
     * Схема привода.
     *
     * @var string
     */
    public $impulsionType;
    /**
     * Тип двигателя.
     *
     * @var string
     */
    public $motorType;
    /**
     * Мощность в л/c
     *
     * @var int
     */
    public $powerHP;
    /**
     * Мощность в кВт
     *
     * @var int
     */
    public $powerKW;
    /**
     * Количество клапанов.
     *
     * @var int
     */
    public $valves;
    /**
     * Код двигателя.
     *
     * @var string
     */
    public $motorCodes;
}