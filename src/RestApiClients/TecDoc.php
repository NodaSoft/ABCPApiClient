<?php

namespace NS\ABCPApi\RestApiClients;

use NS\ABCPApi\Common\CarType;
use NS\ABCPApi\Common\Motorcycle;
use NS\ABCPApi\Common\ServiceErrors;
use NS\ABCPApi\RestClient\Request;
use NS\ABCPApi\RestClient\RestClient;
use NS\ABCPApi\TecDocEntities\AnalogArticle;
use NS\ABCPApi\TecDocEntities\Article;
use NS\ABCPApi\TecDocEntities\ArticlePart;
use NS\ABCPApi\TecDocEntities\ArticleSimplified;
use NS\ABCPApi\TecDocEntities\AssignedArticleAttributes;
use NS\ABCPApi\TecDocEntities\Brand;
use NS\ABCPApi\TecDocEntities\Manufacturer;
use NS\ABCPApi\TecDocEntities\Model;
use NS\ABCPApi\TecDocEntities\ModelVariant;
use NS\ABCPApi\TecDocEntities\Modification;
use NS\ABCPApi\TecDocEntities\ModificationAdaptability;

/**
 * Клиент для доступа к сервису каталог TecDoc
 *
 */
class TecDoc extends RestClient
{
    const DEFAULT_WEB_SERVICE_URL = 'tecdoc.api.abcp.ru';
    /**
     * Значение ключа (USER_KEY) для доступа к TecDoc API
     *
     * @var string
     */
    private $userKey = '';
    /**
     * Логин (USER_LOGIN) для доступа к TecDoc API
     *
     * @var string
     */
    private $userLogin = '';
    /**
     * Пароль (USER_PSW) для доступа к TecDoc API
     *
     * @var string
     */
    private $userPsw = '';
    /**
     * Хост для сервиса TecDoc API
     *
     * @var string
     */
    private $host = '';

    /**
     * Возвращает хост для сервиса TecDoc API, либо если хост не задан дефолтный.
     *
     * @return string
     */
    public function getTecdocHost()
    {
        return $this->host === '' ? self::DEFAULT_WEB_SERVICE_URL : $this->host;
    }

    /**
     * Устанавливает хост для сервиса TecDoc API
     *
     * @param string $host
     * @return TecDoc
     */
    public function setTecdocHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Возвращает значение ключа (USER_KEY) для доступа к TecDoc API
     *
     * @return string
     */
    public function getUserKey()
    {
        return $this->userKey;
    }

    /**
     * Устанавливает значение ключа (USER_KEY) для доступа к TecDoc API
     *
     * @param string $userKey
     * @return TecDoc
     */
    public function setUserKey($userKey)
    {
        $this->userKey = $userKey;

        return $this;
    }

    /**
     * Возвращает логин (USER_LOGIN) для доступа к TecDoc API
     *
     * @return string
     */
    public function getUserLogin()
    {
        return $this->userLogin;
    }

    /**
     * Устанавливает логин (USER_LOGIN) для доступа к TecDoc API
     *
     * @param string $userLogin
     * @return TecDoc
     */
    public function setUserLogin($userLogin)
    {
        $this->userLogin = $userLogin;

        return $this;
    }

    /**
     * Возвращает пароль (USER_PSW) для доступа к TecDoc API
     *
     * @return string
     */
    public function getUserPsw()
    {
        return $this->userPsw;
    }

    /**
     * Устанавливает пароль (USER_PSW) для доступа к TecDoc API
     *
     * @param string $userPsw
     * @return TecDoc
     */
    public function setUserPsw($userPsw)
    {
        $this->userPsw = $userPsw;

        return $this;
    }

    /**
     * TecDoc constructor.
     *
     * @param string $userKey
     * @param string $userLogin
     * @param string $userPsw
     */
    public function __construct($userKey = '', $userLogin = '', $userPsw = '')
    {
        $this->userKey = $userKey;
        $this->userLogin = $userLogin;
        $this->userPsw = $userPsw;
    }

    /**
     * Возвращает массив сущностей производителей (брендов). Можно указать тип автомобиля.
     *
     * @param int $carType
     * @param int $motorcyclesFilter
     * @return Manufacturer[]
     */
    public function getManufacturers($carType = CarType::ALL, $motorcyclesFilter = Motorcycle::ALL)
    {
        return Manufacturer::convertToTecDocEntitiesArray(self::getManufacturersAsArray($carType, $motorcyclesFilter));
    }

    /**
     * Возвращает массив производителей (брендов) в виде массива. Можно указать тип автомобиля.
     *
     * @param int $carType
     * @param int $motorcyclesFilter
     * @return array
     * @throws \Exception
     */
    public function getManufacturersAsArray($carType = CarType::ALL, $motorcyclesFilter = Motorcycle::ALL)
    {
        $requestVars = $this->getAuthenticationData();
        if ($carType) {
            $requestVars['carType'] = $carType;
        }
        $requestVars['motorcyclesFilter'] = $motorcyclesFilter;
        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('manufacturers');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }

    /**
     * Возвращает массив сущностей производителей (брендов). Можно указать тип автомобиля.
     *
     * @return \NS\ABCPApi\TecDocEntities\Brand[]
     * @throws \Exception
     */
    public function getBrands()
    {
        return Brand::convertToTecDocEntitiesArray(self::getBrandsAsArray());
    }

    /**
     * Возвращает массив производителей (брендов) в виде массива. Можно указать тип автомобиля.
     *
     * @return array
     * @throws \Exception
     */
    public function getBrandsAsArray()
    {
        $requestVars = $this->getAuthenticationData();
        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('brands');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }

    /**
     * Возвращает массив с данными для авторизации.
     *
     * @return array
     */
    private function getAuthenticationData()
    {
        return array(
            'userlogin' => $this->getUserLogin(),
            'userpsw' => $this->getUserPsw(),
            'userkey' => $this->getUserKey()
        );
    }

    /**
     * Возвращает массив сущностей Model по идентификатору производителя (бренда).
     *
     * @param int $manufacturerId
     * @param int $carType
     * @return \NS\ABCPApi\TecDocEntities\Model[]
     * @throws \Exception
     */
    public function getModels($manufacturerId, $carType = CarType::CARS)
    {
        return Model::convertToTecDocEntitiesArray(self::getModelsAsArray($manufacturerId, $carType));
    }

    /**
     * Возвращает список моделей по идентификатору производителя (бренда) в виде массива.
     *
     * @param int $manufacturerId
     * @param int $carType
     * @return array
     * @throws \Exception
     */
    public function getModelsAsArray($manufacturerId, $carType = CarType::CARS)
    {
        $requestVars = $this->getAuthenticationData();
        $requestVars['manufacturerId'] = $manufacturerId;
        $requestVars['carType'] = $carType;
        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('models');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }

    /**
     * Вовзращает массив сущностей модификаций по идентфикатору производителя (бренда) и идентификатору модели.
     *
     * @param int $manufacturerId
     * @param int $modelId
     * @param int $carType
     * @return \NS\ABCPApi\TecDocEntities\Modification[]
     * @throws \Exception
     */
    public function getModifications($manufacturerId, $modelId, $carType = CarType::CARS)
    {
        return Modification::convertToTecDocEntitiesArray(self::getModificationsAsArray($manufacturerId, $modelId,
            $carType));
    }

    /**
     * Вовзращает список модификаций по идентфикатору производителя (бренда) и идентификатору модели в виде массива.
     *
     * @param int $manufacturerId
     * @param int $modelId
     * @param int $carType
     * @return array
     * @throws \Exception
     */
    public function getModificationsAsArray($manufacturerId, $modelId, $carType = CarType::CARS)
    {
        $requestVars = $this->getAuthenticationData();
        $requestVars['manufacturerId'] = $manufacturerId;
        $requestVars['modelId'] = $modelId;
        $requestVars['carType'] = $carType;

        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('modifications');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }

    /**
     * Вовзращает массив сущностей модификаций по идентфикатору производителя (бренда) и идентификатору модели.
     *
     * @param int $modificationId
     * @return \NS\ABCPApi\TecDocEntities\Modification
     * @throws \Exception
     */
    public function getModificationById($modificationId)
    {
        $modifications = Modification::convertToTecDocEntitiesArray(self::getModificationByIdAsArray($modificationId));

        return $modifications ? current($modifications) : null;
    }

    /**
     * Вовзращает список модификаций по идентфикатору производителя (бренда) и идентификатору модели в виде массива.
     *
     * @param int $modificationId
     * @return array
     * @throws \Exception
     */
    public function getModificationByIdAsArray($modificationId)
    {
        $requestVars = $this->getAuthenticationData();
        $requestVars['modelVariant'] = $modificationId;

        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('modification');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }

    /**
     * Возвращает дерево категорий для заданной модификации.
     *
     * @param int $modificationId
     * @param int $carType
     * @return \NS\ABCPApi\TecDocEntities\ModelVariant[]
     * @throws \Exception
     */
    public function getModelVariant($modificationId, $carType = CarType::CARS)
    {
        return ModelVariant::convertToTecDocEntitiesArray(self::getModelVariantAsArray($modificationId, $carType));
    }

    /**
     * * Возвращает дерево категорий для заданной модификации в виде массива.
     *
     * @param int $modificationId
     * @param int $carType
     * @return array
     * @throws \Exception
     */
    public function getModelVariantAsArray($modificationId, $carType = CarType::CARS)
    {
        $requestVars = $this->getAuthenticationData();
        $requestVars['modificationId'] = $modificationId;
        $requestVars['carType'] = $carType;
        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('tree');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }

    /**
     * Возвращает список деталей для указанной категории.
     *
     * @param int $modificationId
     * @param int $categoryId
     * @param string $brandName
     * @param int $carType
     * @return \NS\ABCPApi\TecDocEntities\Article[]
     * @throws \Exception
     */
    public function getArticles($modificationId, $categoryId, $brandName, $carType = CarType::CARS)
    {
        return Article::convertToTecDocEntitiesArray(self::getArticlesAsArray($modificationId, $categoryId, $brandName,
            $carType));
    }

    /**
     * Возвращает список деталей для указанной категории в виде массива.
     *
     * @param int $modificationId
     * @param int $categoryId
     * @param string $brandName
     * @param int $carType
     * @return array
     * @throws \Exception
     */
    public function getArticlesAsArray($modificationId, $categoryId, $brandName, $carType = CarType::CARS)
    {
        $requestVars = $this->getAuthenticationData();
        $requestVars['modificationId'] = $modificationId;
        $requestVars['categoryId'] = $categoryId;
        $requestVars['carType'] = $carType;
        if (!empty($brandName)) {
            $requestVars['brandNames'] = array($brandName);
        }
        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('articles');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }

    /**
     * Возвращает список модификаций применимых к заданной детали.
     *
     * @param string $brandName
     * @param string $number
     * @param string $manufacturerName
     * @return string[]
     * @throws \Exception
     */
    public function getModelNamesForApplicability($brandName, $number, $manufacturerName)
    {
        $requestVars = $this->getAuthenticationData();
        $requestVars['brandName'] = $brandName;
        $requestVars['number'] = $number;
        $requestVars['manufacturerName'] = $manufacturerName;
        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('adaptabilityModels');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }

    /**
     * Возвращает список производителей применимых к заданной детали.
     *
     * @param $brandName
     * @param $number
     * @return \NS\ABCPApi\TecDocEntities\Manufacturer[]
     * @throws \Exception
     */
    public function getAdaptabilityManufacturers($brandName, $number)
    {
        return Manufacturer::convertToTecDocEntitiesArray(self::getAdaptabilityManufacturersAsArray($brandName,
            $number));
    }

    /**
     * Возвращает список производителей применимых к заданной детали в виде массива.
     *
     * @param string $brandName
     * @param string $number
     * @return array
     * @throws \Exception
     */
    public function getAdaptabilityManufacturersAsArray($brandName, $number)
    {
        $requestVars = $this->getAuthenticationData();
        $requestVars['brandName'] = $brandName;
        $requestVars['number'] = $number;
        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('adaptabilityManufacturers');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }

    /**
     * Возвращает список модификаций применимых к заданной детали.
     *
     * @param string $brandName
     * @param string $number
     * @param string $manufacturerName
     * @param string $modelName
     * @return \NS\ABCPApi\TecDocEntities\ModificationAdaptability[]
     * @throws \Exception
     */
    public function getAdaptabilityModifications($brandName, $number, $manufacturerName, $modelName)
    {
        return ModificationAdaptability::convertToTecDocEntitiesArray(self::getAdaptabilityModificationsAsArray($brandName,
            $number, $manufacturerName, $modelName));
    }

    /**
     * Возвращает список модификаций применимых к заданной детали в виде массива.
     *
     * @param string $brandName
     * @param string $number
     * @param string $manufacturerName
     * @param string $modelName
     * @return array
     * @throws \Exception
     */
    public function getAdaptabilityModificationsAsArray($brandName, $number, $manufacturerName, $modelName)
    {
        $requestVars = $this->getAuthenticationData();
        $requestVars['brandName'] = $brandName;
        $requestVars['number'] = $number;
        $requestVars['manufacturerName'] = $manufacturerName;
        $requestVars['modelName'] = $modelName;
        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('adaptabilityModifications');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }

    /**
     * Возвращает спискок аналогов по номеру без указания бренда.
     *
     * @param string $number
     * @param int $analogType
     * @return AnalogArticle[]
     * @throws \Exception
     */
    public function getAnalogs($number, $analogType)
    {
        return AnalogArticle::convertToTecDocEntitiesArray(self::getAnalogsAsArray($number, $analogType));
    }

    /**
     * Возвращает спискок аналогов по номеру без указания бренда в виде массива.
     *
     * @param string $number
     * @param int $analogType
     * @return array
     * @throws \Exception
     */
    public function getAnalogsAsArray($number, $analogType)
    {
        $requestVars = $this->getAuthenticationData();
        $requestVars['number'] = $number;
        $requestVars['type'] = $analogType;
        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('analogs');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }

    /**
     * Возвращает детализированную информацию о детали.
     *
     * @param int $articleId
     * @return Article
     * @throws \Exception
     */
    public function getArticle($articleId)
    {
        return Article::createByData(self::getArticleAsArray($articleId));
    }

    /**
     * Возвращает детализированную информацию о детали в виде массива.
     *
     * @param int $articleId
     * @return array
     * @throws \Exception
     */
    public function getArticleAsArray($articleId)
    {
        $requestVars = $this->getAuthenticationData();
        $requestVars['articleId'] = $articleId;
        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('articleInfo');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }

    /**
     * Возвращает информацию о детали с настоящими номерами.
     *
     * @param int $articleId
     * @return ArticlePart[]
     * @throws \Exception
     */
    public function getRealNumberArticles($articleId)
    {
        return ArticlePart::convertToTecDocEntitiesArray(self::getRealNumberArticlesAsArray($articleId));
    }

    /**
     * Возвращает детали с настоящими номерами в виде массива.
     *
     * @param int $articleId
     * @return array
     * @throws \Exception
     */
    public function getRealNumberArticlesAsArray($articleId)
    {
        $requestVars = $this->getAuthenticationData();
        $requestVars['articleId'] = $articleId;
        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('realNumberArticles');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }

    /**
     * Возвращает связанные аттрибуты для детали.
     *
     * @param array $articleIdLinkIdPairs
     * @param int $manufacturerId
     * @param int $modelId
     * @param int $modificationId
     * @return AssignedArticleAttributes[]
     */
    public function getAssignedArticleAttributes($articleIdLinkIdPairs, $manufacturerId, $modelId, $modificationId)
    {
        return AssignedArticleAttributes::convertToTecDocEntitiesArray(self::getAssignedArticleAttributesAsArray($articleIdLinkIdPairs,
            $manufacturerId, $modelId, $modificationId));
    }

    /**
     * Возвращает связанные аттрибуты для детали в виде массива.
     *
     * @param array $articleIdLinkIdPairs
     * @param int $manufacturerId
     * @param int $modelId
     * @param int $modificationId
     * @return array
     * @throws \Exception
     */
    public function getAssignedArticleAttributesAsArray(
        $articleIdLinkIdPairs,
        $manufacturerId,
        $modelId,
        $modificationId
    ) {
        $requestVars = $this->getAuthenticationData();
        $requestVars['articleIdPairs'] = $articleIdLinkIdPairs;
        $requestVars['manufacturerId'] = $manufacturerId;
        $requestVars['modelId'] = $modelId;
        $requestVars['modificationId'] = $modificationId;
        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('assignedArticleAttributes')
            ->setMethod('POST');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }


    /**
     * Возвращает список деталей для указанной категории.
     *
     * Содержит сокращенное количество полей.
     *
     * @param int $modificationId
     * @param int $categoryId
     * @param string $brandName
     * @param int $carType
     * @return \NS\ABCPApi\TecDocEntities\ArticleSimplified[]
     * @throws \Exception
     */
    public function getArticleSimplified($modificationId, $categoryId, $brandName, $carType)
    {
        return ArticleSimplified::convertToTecDocEntitiesArray(self::getArticleSimplifiedAsArray($modificationId,
            $categoryId, $brandName, $carType));
    }

    /**
     * Возвращает список деталей для указанной категории в виде массива.
     *
     * Содержит сокращенное количество полей.
     *
     * @param int $modificationId
     * @param int $categoryId
     * @param string $brandName
     * @param int $carType
     * @return array
     * @throws \Exception
     */
    public function getArticleSimplifiedAsArray($modificationId, $categoryId, $brandName, $carType)
    {
        $requestVars = $this->getAuthenticationData();
        $requestVars['modificationId'] = $modificationId;
        $requestVars['categoryId'] = $categoryId;
        $requestVars['carType'] = $carType;
        if (!empty($brandName)) {
            $requestVars['brandNames[]'] = $brandName;
        }
        $request = new Request(TecDoc::getTecdocHost());
        $request->setParameters($requestVars)
            ->setOperation('articlesSimplified');
        $response = $this->send($request)->getAsArray();
        if (isset($response['errorCode'])) {
            throw new \Exception(ServiceErrors::getErrorMessageByCode($response['errorCode']), $response['errorCode']);
        }

        return $response;
    }

}