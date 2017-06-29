# php клиент для abcp api

### [Официальный сайт платформы abcp](http://abcp.ru)

### Установка
Установка с использованием composer и командной строки:

```bash
php composer.phar require nodasoft/abcp_api_client:1.2
```

Установка через конфигурационный файл composer.json:

```json
  "require": {
    "nodasoft/abcp_api_client": "3.4"
  }
```

Установка через git:
 
скопировать репозиторий в проект и включить автозагрузчик:

```php
require_once '__autoload.php';
```

### Использование
Перед началом использования клиента необходимо получить данные для авторизации у менеджера платформы abcp

Ключ пользователя (userKey), e-mail для которого активирована услуга и пароль для доступа к службе.

Инициализация клиента:

```php
$tecDocRestClient = new \NS\ABCPApi\RestApiClients\TecDoc();
$tecDocRestClient->setUserKey('your_userKey)
    ->setUserLogin('your_email')
    ->setUserPsw('your_password');
```

Установка произвольного адреса:

```php
$tecDocRestClient->setHost
```

Получение списка производителей:

```php
//$carType - тип автомобиля. 0 - все, 1 - легковые, 2- грузовые, 3-малотонажные
//$motorcyclesFilter - фильтрация по мотоциклам. 0 - все, 1 - только автомобили, 2 - только мотоциклы
$manufacturers = $tecDocRestClient->getManufacturers($carType, $motorcyclesFilter);
```

Получение списка моделей:

```php
//$manufacturerId - идентификатор производителя
$models = $tecDocRestClient->getModels($manufacturerId);
```

Получение списка модификаций:

```php
//$manufacturerId - идентификатор производителя
//$modelId - идентификатор модели
$modifications = $tecDocRestClient->getModifications($manufacturerId, $modelId);
```

Получение дерева групп деталей:

```php
//$modificationId - идентификатор модификации
$tree = $tecDocRestClient->getModelVariant($modificationId);
```

Получение списка деталей по группе:

```php
//$modificationId - идентификатор модификации
//$categoryId - идентификатор категории
$articles = $tecDocRestClient->getArticles($modificationId, $categoryId);
```

Получение списка деталей по группе, упрощенный:

```php
//$modificationId - идентификатор модификации
//$categoryId - идентификатор категории
$articles = $tecDocRestClient->getArticlesSimplified($modificationId, $categoryId);
```

Получение детализированной информации по детали:

```php
//$articleId - идентификатор детали
$article = $tecDocRestClient->getArticle($articleId);
````

Получение списка деталей по применимости:

```php
//$articleId - идентификатор детали
$adaptability = $tecDocRestClient->getAdaptability($articleId);
````

Получение списка деталей аналогов:

```php
//$articleId - идентификатор детали
//$analogType - тип аналогов, описан классом \NS\TecDocSite\Common\AnalogTypes
$analogs = $tecDocRestClient->getAnalogs($number, $analogType);
````