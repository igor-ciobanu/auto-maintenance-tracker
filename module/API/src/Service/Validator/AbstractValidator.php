<?php

namespace API\Service\Validator;

use API\Helper\HasErrorMessage;
use Zend\Validator\AbstractValidator as ZendValidator;
use Zend\Validator\Digits;
use Zend\Validator\NotEmpty;

class AbstractValidator
{
    use HasErrorMessage;

    protected function validateField(array $validators, $field, $label)
    {
        /** @var ZendValidator $validator */
        foreach ($validators as $validator) {
            if (! $validator->isValid($field)) {
                foreach ($validator->getMessages() as $message) {
                    $this->addError($label . ': ' . $message);
                }
            }
        }
    }

    protected function getRequiredStringValidators()
    {
        return [new NotEmpty()];
    }

    protected function getRequiredDigitsValidators()
    {
        return [new NotEmpty(), new Digits()];
    }
}
