<?php namespace Jotun\Exceptions;
use Exception;

class InvalidProductException extends Exception
{
    protected $code = -2;
    protected $passedProductId;

    public function __construct($productId)
    {
        $this->passedProductId = $productId;
        parent::__construct('Product with ID is not exits.');
    }

    public function getPassedProductId()
    {
        return $this->passedProductId;
    }
}