<?php

namespace API\Service\Validator;

use API\RequestModel\Car as CarRequest;
use Zend\Validator\Between;
use Zend\Validator\NotEmpty;

class Car extends AbstractValidator
{
    const CAR_VIN = 'Car VIN';
    const CAR_YEAR = 'Car Year';
    const CAR_KM = 'Car KM';
    const CAR_TYPE_ID = 'Car Type Id';
    const CAR_MODEL_ID = 'Model Id';

    public function validate(CarRequest $request)
    {
        $this->validateField($this->getRequiredStringValidators(), $request->vin, self::CAR_VIN);
        $this->validateField($this->getYearValidators(), $request->year, self::CAR_YEAR);
        $this->validateField($this->getRequiredDigitsValidators(), $request->km, self::CAR_KM);
        $this->validateField($this->getRequiredDigitsValidators(), $request->car_type_id, self::CAR_TYPE_ID);
        $this->validateField($this->getRequiredDigitsValidators(), $request->model_id, self::CAR_MODEL_ID);
    }

    protected function getYearValidators()
    {
        return [
            new NotEmpty(),
            new Between([
                'inclusive' => true,
                'min' => 1900,
                'max' => date("Y")
            ])
        ];
    }
}
