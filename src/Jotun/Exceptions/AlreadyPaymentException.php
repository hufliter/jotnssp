<?php namespace Jotun\Exceptions;
use Entity\User;
use Exception;

class AlreadyPaymentException extends Exception
{
    /**
     * @var User
     */
    private $reseller;
    /**
     * @var string
     */
    private $timeCode;

    protected $code = -2;

    /**
     * @param User $reseller
     * @param int $timeCode
     */
    public function __construct($reseller, $timeCode)
    {
        $this->reseller = $reseller;
        $this->timeCode = $timeCode;

        parent::__construct('Payment for reseller is already exists');
    }

    /**
     * @return User
     */
    public function getReseller()
    {
        return $this->reseller;
    }

    /**
     * @return int|string
     */
    public function getTimeCode()
    {
        return $this->timeCode;
    }
}