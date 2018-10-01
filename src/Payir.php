<?php
/**
 * Created by PhpStorm.
 * User: ahmad
 * Date: 10/1/2018
 * Time: 5:32 PM
 */

namespace Ahmadmrj\Payir;


class Payir extends Payment
{
    public $apiStatusId;
    public $transId;

    public function sendApiRequest($amount,$invoice_id){
    // @Todo: separate tasks
        $api = $this->config->apiKey;
        $redirect = $this->config->redirectUrl;
        $mobile = $this->config->mobileNumber;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->config->gateWayApiUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"api=$api&amount=$amount&redirect=$redirect&mobile=$mobile&factorNumber=$invoice_id");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);
        curl_close($ch);

        $this->getApiResult($res);

        return $res;
    }

    public function getApiResult($result){
        $decoded_result = json_decode($result);

        $this->apiStatusId = $decoded_result->status;

        if($this->apiStatusId === 1){
            $this->transId = $decoded_result->transId;
        }
        else{
            //@TODO: handle Exceptions
        }
    }
}