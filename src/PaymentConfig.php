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
    public $redirectUrl;
    public $mobileNumber;

    public function __construct(Array $config)
    {
        $this->gateWayApiUrl = $config['gateWayApiUrl'];
        $this->apiKey = $config['apiKey'];
        $this->redirectUrl = $config['redirectUrl'];
        $this->mobileNumber = $config['mobileNumber'];
    }
}