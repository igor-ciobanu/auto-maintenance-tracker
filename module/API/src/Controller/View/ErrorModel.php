<?php

namespace API\Controller\View;

use Zend\View\Model\JsonModel;

/**
 * Class ErrorModel
 */
class ErrorModel extends JsonModel
{
    /**
     * @param \Exception $e
     */
    public function __construct(\Exception $e)
    {
        $message = 'API error. ' . $e->getMessage();
        $out = [
            'message' => $message
        ];
        parent::__construct($out);
    }
}
