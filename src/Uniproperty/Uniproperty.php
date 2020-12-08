<?php

namespace Iconic\Uniproperty;

use Iconic\Uniproperty\Exception\PropertyException;

class Uniproperty
{
    public static function get(object $object, string $propertyName)
    {
        if (array_key_exists($propertyName, get_object_vars($object))) {
            $actionable = $propertyName;

            return $object->$propertyName;
        }

        $method = 'get'.ucfirst($propertyName);

        $actionable = '';

        if (method_exists($object, $method)) {
            $actionable = $method;

            return $object->{$method}();
        }

        //TODO: this needs test scenario
        //TODO: And also check for booleans
        $method = 'is'.ucfirst($propertyName);

        if (method_exists($object, $method)) {
            $actionable = $method;

            return $object->{$method}();
        }

        throw new PropertyException($actionable, $object);
    }

    public static function set(object $object, string $propertyName, $propertyValue)
    {
        $actionable = '';
        $method = 'set'.ucfirst($propertyName);

        if (method_exists($object, $method)) {
            //TODO: Test this? Maybe not. depends on the tests. check it out.
            $actionable = $method;
            $object->{$method}($propertyValue);

            return;
        }

        if (property_exists($object, $propertyName)) {
            $actionable = $propertyName;
            $object->$propertyName = $propertyValue;

            return;
        }

        throw new PropertyException($actionable, $object);
    }

    public static function check(object $object, string $propertyName)
    {
        $methodGet = 'get'.ucfirst($propertyName);
        $methodIs = 'is'.ucfirst($propertyName);

        return property_exists($object, $propertyName) || method_exists($object, $methodGet) || method_exists($object, $methodIs);
    }
}
