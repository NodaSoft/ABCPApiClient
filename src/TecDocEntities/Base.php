<?php
namespace NS\ABCPApi\TecDocEntities;

use NS\ABCPApi\Common\AnnotationHelper;

/**
 * Базовый класс для всех сущностей TecDoc
 */
class Base
{
    /**
     * Преобразовывает массив из сущностей представленных в виде массива, в массив сущностей в виде объектов.
     *
     * @param array|NULL $data
     * @return array
     */
    public static function convertToTecDocEntitiesArray($data)
    {
        if (is_null($data)) {
            return null;
        }
        $className = get_called_class();
        $entity = new $className;
        if ($entity instanceof Base) {
            $collection = array();
            foreach ($data as $oneItem) {
                if (is_array($oneItem)) {
                    $collection[] = $entity::createByData($oneItem);
                }
            }
            return $collection;
        }
        return null;
    }

    /**
     * Возвращает экземпляр класса со свойствами заполнеными согласно ключам массива.
     *
     * @param array $data
     * @return Base|mixed
     */
    public static function createByData(array $data)
    {
        $className = get_called_class();
        $instance = new $className;
        $properties = AnnotationHelper::getPropertiesTypes(get_called_class());
        foreach ($properties as $oneProperty) {
            if (isset($data[$oneProperty['name']])) {
                switch (true) {
                    case in_array($oneProperty['type'], array('int', 'integer')):
                        $instance->{$oneProperty['name']} = (int)$data[$oneProperty['name']];
                        break;
                    case $oneProperty['type'] === '\DateTime':
                        $instance->{$oneProperty['name']} = self::getDateTimeByYearMonth($data[$oneProperty['name']]);
                        break;
                    case $oneProperty['type'] === 'boolean':
                        $instance->{$oneProperty['name']} = (bool)$data[$oneProperty['name']];
                        break;
                    default:
                        $instance->{$oneProperty['name']} = $data[$oneProperty['name']];
                }
            }
        }
        return $instance;
    }

    /**
     * Конвертирует дату в формате "Ym" в объект типа DateTime. Либо возвращает NULL если не получилось преобразовать.
     *
     * @param $yearMonth
     * @return \DateTime|null
     */
    public static function getDateTimeByYearMonth($yearMonth)
    {
        if (strlen($yearMonth) == 6) {
            $date = new \DateTime();
            $date->setDate(substr($yearMonth, 0, 4), substr($yearMonth, -2), 1);
            $date->setTime(0, 0, 0);
            return $date;
        }
        return null;
    }

}