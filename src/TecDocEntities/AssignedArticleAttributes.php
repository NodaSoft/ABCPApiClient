<?php

namespace NS\ABCPApi\TecDocEntities;

/**
 * @method AssignedArticleAttributes[] convertToTecDocEntitiesArray($data) static
 */
class AssignedArticleAttributes extends Base
{
    /**
     * Идентификатор детали.
     *
     * @var int
     */
    public $articleId;
    /**
     * Идентификатор детали.
     *
     * @var int
     */
    public $articleLinkId;

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
     * @return AssignedArticleAttributes
     */
    public static function createByData(array $data)
    {
        $instance = parent::createByData($data);
        $instance->attributes = is_array($instance->attributes) ? ArticleAttribute::convertToTecDocEntitiesArray($instance->attributes) : $instance->attributes;

        return $instance;
    }
}