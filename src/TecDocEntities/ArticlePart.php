<?php

namespace NS\ABCPApi\TecDocEntities;

/**
 * @method ArticlePart[] convertToTecDocEntitiesArray($data) static
 */
class ArticlePart extends Base
{
    /**
     * Идентификатор детали.
     *
     * @var int
     */
    public $id;
    /**
     * Номер детали.
     *
     * @var string
     */
    public $number;
    /**
     * Описание детали.
     *
     * @var
     */
    public $description;
    /**
     * Дополнительное название.
     *
     * @var
     */
    public $addName;
    /**
     * Идентификатор производителя (бренда)
     *
     * @var int
     */
    public $brandId;
    /**
     * Наименование производителя (бренда)
     *
     * @var string
     */
    public $brandName;
    /**
     * Идентификатор типа детали.
     *
     * @var int
     */
    public $state;
    /**
     * Название типа детали.
     *
     * @var string
     */
    public $stateName;
    /**
     * Идентификатор группы товара.
     *
     * @var int
     */
    public $genericArticleId;
    /**
     * Непосредственные аттрибуты детали.
     *
     * @var ArticleAttribute[]
     */
    public $attributes;

    /**
     * Возвращает экземпляр класса со свойствами заполнеными согласно ключам массива.
     *
     * @param array $data
     * @return ArticlePart
     */
    public static function createByData(array $data)
    {
        $instance = parent::createByData($data);
        $instance->attributes = is_array($instance->attributes) ? ArticleAttribute::convertToTecDocEntitiesArray($instance->attributes) : $instance->attributes;

        return $instance;
    }
}