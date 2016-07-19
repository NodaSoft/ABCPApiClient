<?php
namespace NS\ABCPApi\TecDocEntities;

/**
 * @method ModificationAdaptability[] convertToTecDocEntitiesArray($data) static
 * @method ModificationAdaptability createByData($data) static
 */
class ModificationAdaptability extends Base
{
    /**
     * Название модификации.
     *
     * @var string
     */
    public $name;
    /**
     * Название модели.
     *
     * @var string
     */
    public $modelName;
    /**
     * Название производителя.
     *
     * @var string
     */
    public $manufacturerName;
    /**
     * Дата начала выпуска модификации.
     *
     * @var \DateTime
     */
    public $yearFrom = null;
    /**
     * Дата окончания выпуска модификации. NULL если еще выпускается.
     *
     * @var \DateTime
     */
    public $yearTo = null;
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