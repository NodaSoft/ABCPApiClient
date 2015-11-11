<?php
namespace NS\ABCPApi\TecDocEntities;

/**
 * @method ArticleDocument[] convertToTecDocEntitiesArray($data) static
 * @method ArticleDocument createByData($data) static
 */
class ArticleDocument extends Base
{
    /**
     * Идентификатор
     *
     * @var int
     */
    public $id;
    /**
     * Тип файла (например, image/jpeg)
     *
     * @var string
     */
    public $fileType;
    /**
     * Данные
     *
     * @var string
     */
    public $data;
}