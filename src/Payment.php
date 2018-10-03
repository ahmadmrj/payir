<?php
/**
 * Created by PhpStorm.
 * User: ahmad
 * Date: 10/1/2018
 * Time: 12:32 PM
 */

namespace Ahmadmrj\Payir;


abstract class Payment implements PaymentInterface
{
    public $config;
    public $input_config;

    public function __construct($conf)
    {
        $this->input_config = $conf;
        $this->setConfig();
    }

    public function setConfig()
    {
        $this->config = new PaymentConfig($this->input_config);
    }

    public function getConfig()
    {
        return $this->config;
    }

//    public function
}