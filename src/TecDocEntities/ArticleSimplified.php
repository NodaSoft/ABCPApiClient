<?php
namespace NS\ABCPApi\TecDocEntities;

/**
 * @method ArticleSimplified[] convertToTecDocEntitiesArray($data) static
 * @method ArticleSimplified createByData($data) static
 */
class ArticleSimplified extends Base
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
     * @var string
     */
    public $description;

    /**
     * Наименование производителя (бренда)
     *
     * @var string
     */
    public $brandName;

    /**
     * Идентификатор типа детали.
     *
     * @var string
     */
    public $imageName;

    /**
     * Название типа детали.
     *
     * @var string
     */
    public $imageUrl;
}