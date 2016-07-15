<?php
namespace NS\ABCPApi\TecDocEntities;

/**
 * @method MainArticle[] convertToTecDocEntitiesArray($array) static
 * @method MainArticle createByData($data) static
 */
class MainArticle extends Base
{
    /**
     * Идентификатор детали
     *
     * @var int
     */
    public $articleId;

    /**
     * Название детали
     *
     * @var string
     */
    public $name;
    /**
     * Добавочное название детали
     *
     * @var string
     */
    public $addName;
    /**
     * Номер детали
     *
     * @var string
     */
    public $number;
}