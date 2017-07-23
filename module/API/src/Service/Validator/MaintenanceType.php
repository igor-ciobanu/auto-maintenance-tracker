<?php

namespace API\Service\Validator;

use API\RequestModel\MaintenanceType as MaintenanceTypeRequest;

class MaintenanceType extends AbstractValidator
{
    const MAINTENANCE_TYPE_NAME = 'MaintenanceType Name';

    public function validate(MaintenanceTypeRequest $request)
    {
        $this->validateField($this->getRequiredStringValidators(), $request->name, self::MAINTENANCE_TYPE_NAME);
    }
}
