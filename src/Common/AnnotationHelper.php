<?php
namespace NS\ABCPApi\Common;

use ReflectionClass;

class AnnotationHelper
{
    /**
     * Тип свойства по умолчанию.
     */
    const DEFAULT_PROPERTY_TYPE = 'string';

    /**
     * Массив содержит поддерживаемые типы данных.
     *
     * @var string[]
     */
    private static $availableTypes = array(
        'int',
        'string',
        '\DateTime',
        'boolean',
        'integer',
    );

    /**
     * Возвращает список свойств по имени класса.
     *
     * @param $className
     * @return array [string 'name', string 'type']
     */
    public static function getPropertiesTypes($className)
    {
        if (!class_exists($className)) {
            return array();
        }
        $reflection = new ReflectionClass($className);
        $outputPropertiesNames = array();
        foreach ($reflection->getProperties() as $onePropertyReflection) {
            $propertyType = self::DEFAULT_PROPERTY_TYPE;
            preg_match('/@var\s+([\\\\]?\w+)/', $onePropertyReflection->getDocComment(), $matches);
            if (isset($matches[1]) && in_array($matches[1], self::$availableTypes, true)) {
                $propertyType = $matches[1];
            }
            $outputPropertiesNames[] = array(
                'name' => $onePropertyReflection->getName(),
                'type' => $propertyType
            );
        }
        return $outputPropertiesNames;
    }
}