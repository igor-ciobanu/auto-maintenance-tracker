<?php

namespace API\RequestModel;

class AbstractRequestModel
{

    /**
     * AbstractRequestModel constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $reflect = new \ReflectionClass($this);
        foreach ($reflect->getProperties() as $prop) {
            $propertyName = $prop->getName();
            if (isset($request[$propertyName])) {
                $this->$propertyName = $request[$prop->getName()];
            }
        }
    }
}
