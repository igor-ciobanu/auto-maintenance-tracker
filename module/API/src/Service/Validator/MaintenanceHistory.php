<?php

namespace API\Service\Validator;

use API\RequestModel\MaintenanceHistory as MaintenanceHistoryRequest;

class MaintenanceHistory extends AbstractValidator
{
    const MODEL_KM = 'KM Name';
    const CAR_ID = 'Car Id';
    const MAINTENANCE_RULE_ID = 'Maintenance Rule Id';

    public function validate(MaintenanceHistoryRequest $request)
    {
        $this->validateField($this->getRequiredDigitsValidators(), $request->km, self::MODEL_KM);
        $this->validateField($this->getRequiredDigitsValidators(), $request->car_id, self::CAR_ID);
        $this->validateField(
            $this->getRequiredDigitsValidators(),
            $request->maintenance_rule_id,
            self::MAINTENANCE_RULE_ID
        );
    }
}
