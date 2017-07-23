<?php
/**
 * Created by PhpStorm.
 * User: iciobanu
 * Date: 6/22/16
 * Time: 9:08 AM
 */

namespace API\Controller\View;

use Zend\View\Model\JsonModel;

/**
 * Class ErrorModel
 */
class ErrorValidation extends JsonModel
{
    /**
     * @param \Exception $e
     */
    public function __construct(\Exception $e)
    {
        $message = json_decode($e->getMessage(), true);
        if (! $message) {
            $message = $e->getMessage();
        }
        $out = [
            'message' => $message,
        ];
        parent::__construct($out);
    }
}
