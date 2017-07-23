<?php

namespace API\Service\Validator;

use API\Helper\HasErrorMessage;
use API\RequestModel\CarType as CarTypeRequest;

use Zend\Validator\NotEmpty;

class CarType extends AbstractValidator
{
    const CAR_TYPE_NAME = 'CarType Name';

    public function validate(CarTypeRequest $request)
    {
        $this->validateField($this->getRequiredStringValidators(), $request->type, self::CAR_TYPE_NAME);
    }
}
