<?php
namespace NS\ABCPApi\TecDocEntities;

/**
 * @method ArticleInfo[] convertToTecDocEntitiesArray($data) static
 * @method ArticleInfo createByData($data) static
 */
class ArticleInfo extends Base
{
    /**
     * Идентификатор информации
     *
     * @var int
     */
    public $id;
    /**
     * Текстовое описание
     *
     * @var string
     */
    public $text;
    /**
     * Идентификатор типа
     *
     * @var int
     */
    public $typeId;
    /**
     * Название типа
     *
     * @var string
     */
    public $typeName;
}