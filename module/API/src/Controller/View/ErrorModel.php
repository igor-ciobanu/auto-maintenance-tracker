<?php
/**
 * Created by PhpStorm.
 * User: igorciobanu
 * Date: 11/21/14
 * Time: 12:10 PM
 */
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
