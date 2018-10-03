<?php
/**
 * Created by PhpStorm.
 * User: ahmad
 * Date: 10/1/2018
 * Time: 4:54 PM
 */

namespace Ahmadmrj\Payir;


class PaymentConfig
{
    public $gateWayApiUrl;
    public $apiKey;
    public $callbackUrl;
    public $verifyUrl;
    public $redirectUrl;
    public $mobileNumber;

    public function __construct(Array $config)
    {
        $this->gateWayApiUrl = $config['gateWayApiUrl'];
        $this->apiKey = $config['apiKey'];
        $this->redirectUrl = $config['redirectUrl'];
        $this->verifyUrl = $config['verifyUrl'];
        $this->callbackUrl = $config['callbackUrl'];
        $this->mobileNumber = $config['mobileNumber'];
    }
}