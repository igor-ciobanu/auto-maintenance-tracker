<?php

namespace API\Service\Validator;

use API\Helper\HasErrorMessage;
use API\RequestModel\Mark as MarkRequest;

use Zend\Validator\NotEmpty;

class Mark extends AbstractValidator
{
    const MARK_NAME = 'Mark Name';

    public function validate(MarkRequest $request)
    {
        $this->validateField($this->getRequiredStringValidators(), $request->name, self::MARK_NAME);
    }
}
