<?php

namespace Iconic\Uniproperty\Exception;

class PropertyException extends \Exception
{
    public function __construct(string $propertyName, object $object)
    {
        $class = get_class($object);
        parent::__construct(
            "The property '$propertyName' does not exist in '$class'", $code = 0, $previous = null
        );
    }
}
