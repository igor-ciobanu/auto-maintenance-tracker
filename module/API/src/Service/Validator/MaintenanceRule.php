<?php

namespace API\Service\Validator;

use API\RequestModel\MaintenanceRule as MaintenanceRuleRequest;

class MaintenanceRule extends AbstractValidator
{
    const MODEL_KM = 'KM Name';
    const CAR_TYPE_ID = 'Car Type Id';
    const MAINTENANCE_TYPE_ID = 'Maintenance Type Id';

    public function validate(MaintenanceRuleRequest $request)
    {
        $this->validateField($this->getRequiredDigitsValidators(), $request->km, self::MODEL_KM);
        $this->validateField($this->getRequiredDigitsValidators(), $request->car_type_id, self::CAR_TYPE_ID);
        $this->validateField(
            $this->getRequiredDigitsValidators(),
            $request->maintenance_type_id,
            self::MAINTENANCE_TYPE_ID
        );
    }
}
