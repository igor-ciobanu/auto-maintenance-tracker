<?php
/**
 * @author Cosmin Dordea <cosmin.dordea@yopeso.com
 * @copyright Yopeso
 */
namespace API\Helper;

trait HasErrorMessage
{
    private $errors = [];

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    /**
     * @return string
     */
    public function getErrorJson()
    {
        return json_encode($this->errors);
    }

    /**
     *
     * @param string $message
     */
    final public function addError($message)
    {
        $this->errors[] = $message;
    }
}
