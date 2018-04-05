<?php

namespace NS\ABCPApi\TecDocEntities;

/**
 * @method Article[] convertToTecDocEntitiesArray($data) static
 */
class Article extends Base
{
    /**
     * Идентификатор детали.
     *
     * @var int
     */
    public $id;
    /**
     * Идентификатор детали.
     *
     * @var int
     */
    public $articleLinkId;
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
     * Информация о товаре.
     *
     * @var ArticleInfo
     */
    public $info;
    /**
     * Главная деталь (используется для отсева псевдодеталей).
     *
     * @var MainArticle[]
     */
    public $mainArticles;
    /**
     * Непосредственные аттрибуты детали.
     *
     * @var ArticleAttribute[]
     */
    public $attributes;
    /**
     * Документы привязанные к детали. Как правило изображения.
     *
     * @var ArticleDocument
     */
    public $documents;
    /**
     * Оригинальные номера.
     *
     * @var OENNumber[]
     */
    public $oenNumbers;
    /**
     * Штрих-код
     *
     * @var string[]
     */
    public $eanNumber;

    /**
     * Возвращает экземпляр класса со свойствами заполнеными согласно ключам массива.
     *
     * @param array $data
     * @return Article
     */
    public static function createByData(array $data)
    {
        $instance = parent::createByData($data);
        $instance->info = is_array($instance->info) ? ArticleInfo::createByData($instance->info) : $instance->info;
        $instance->documents = is_array($instance->documents) ? ArticleDocument::createByData($instance->documents) : $instance->documents;
        $instance->oenNumbers = is_array($instance->oenNumbers) ? OENNumber::convertToTecDocEntitiesArray($instance->oenNumbers) : $instance->oenNumbers;
        $instance->attributes = is_array($instance->attributes) ? ArticleAttribute::convertToTecDocEntitiesArray($instance->attributes) : $instance->attributes;
        $instance->mainArticles = is_array($instance->mainArticles) ? MainArticle::convertToTecDocEntitiesArray($instance->mainArticles) : $instance->mainArticles;

        return $instance;
    }
}