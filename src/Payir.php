<?php
/**
 * Created by PhpStorm.
 * User: ahmad
 * Date: 10/1/2018
 * Time: 5:32 PM
 */

namespace Ahmadmrj\Payir;

use Illuminate\Support\Facades\Redirect;

class Payir extends Payment
{
    const SUCCESSFUL_STATUS = '1';

    public $apiStatusId;
    public $apiVerifyStatusId;
    public $transId;
    public $paymentErrorMessage;
    public $verifyErrorMessage;

    public function sendApiRequest($amount,$invoice_id){
    // @Todo: separate tasks
        $api = $this->config->apiKey;
        $redirect = $this->config->callbackUrl;
        $mobile = $this->config->mobileNumber;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->config->gateWayApiUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"api=$api&amount=$amount&redirect=$redirect&mobile=$mobile&factorNumber=$invoice_id");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);
        curl_close($ch);

        return $this->getApiResult($res);
    }

    public function getApiResult($result){
        $decoded_result = json_decode($result);

        $this->apiStatusId = $decoded_result->status;
        //Api call was successful.
        if($this->apiStatusId === 1){
            $this->transId = $decoded_result->transId;

            return true;
        }
        //call was failed.
        else
        {
            $this->paymentErrorMessage = $decoded_result->errorMessage;

            return false;
        }
    }

    public function verify($request){
        $api = $this->config->apiKey;
        $trans_id = $request->transId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->config->verifyUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "api=$api&transId=$trans_id");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);
        curl_close($ch);

        return $this->getApiVerifyResult($res);
    }

    public function getApiVerifyResult($result){
        $decoded_result = json_decode($result);

        $this->apiVerifyStatusId = $decoded_result->status;

        if($this->apiVerifyStatusId === 1){
            return true;
        }
        else
        {
            $this->verifyErrorMessage = $decoded_result->errorMessage;

            return false;
        }
    }
}