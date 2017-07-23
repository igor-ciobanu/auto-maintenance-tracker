<?php

namespace API\Service\Validator;

use API\RequestModel\Model as ModelRequest;

class Model extends AbstractValidator
{
    const MODEL_NAME = 'Model Name';
    const MARK_ID = 'Mark Id';

    public function validate(ModelRequest $request)
    {
        $this->validateField($this->getRequiredStringValidators(), $request->name, self::MODEL_NAME);
        $this->validateField($this->getRequiredDigitsValidators(), $request->mark_id, self::MARK_ID);
    }
}
