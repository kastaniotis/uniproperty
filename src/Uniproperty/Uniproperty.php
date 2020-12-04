<?php

namespace Iconic\Uniproperty;

use Iconic\Uniproperty\Exception\PropertyException;

class Uniproperty
{
    public static function get(object $object, string $propertyName)
    {
        $method = 'get'.ucfirst($propertyName);

        if (method_exists($object, $method)) {
            return $object->{$method}();
        }

        if (property_exists($object, $propertyName)) {
            return $object->$propertyName;
        }

        throw new PropertyException($propertyName, $object);
    }

    public static function set(object $object, string $propertyName, string $propertyValue)
    {
        $method = 'set'.ucfirst($propertyName);

        if (method_exists($object, $method)) {
            $object->{$method}($propertyValue);

            return;
        }

        if (property_exists($object, $propertyName)) {
            $object->$propertyName = $propertyValue;

            return;
        }

        throw new PropertyException($propertyName, $object);
    }

    public static function check(object $object, string $propertyName)
    {
        $method = 'get'.ucfirst($propertyName);

        return property_exists($object, $propertyName) || method_exists($object, $method);
    }
}
