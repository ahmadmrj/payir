# payir
A Laravel library to implement payment operation with pay.ir service

To install the package:
```
composer install ahmadmrj/payir
````

After install add this to the `provider` section in your config/app.php to use the package as a service provider:
```
'providers' => [
  .
  .
  Ahmadmrj\Payir\PaymentServiceProvider::class
]
````

A sample of the Payment controller: 

```PHP
<?php

namespace App\Http\Controllers;

use Ahmadmrj\Payir\Payir;

class PaymentController extends Controller
{
    public $payment;

    public function __construct()
    {
        $this->payment = new Payir([
            'gateWayApiUrl' => 'https://pay.ir/payment/send',
            'redirectUrl' => 'https://pay.ir/payment/gateway/',
            'verifyUrl' => 'https://pay.ir/payment/verify',
            'apiKey' => 'test',
            'callbackUrl' => Your Call Back URL,
            'mobileNumber' => '',
        ]);
    }

    public function pay(){
        $amount = AMOUNT;
        $invoice_id = Faktor NUMBER;
        $status = $this->payment->sendApiRequest($amount,$invoice_id);

        if($status) {
            // redirect to bank payment page
            return redirect($this->payment->config->redirectUrl . $this->payment->transId);
        }else{
            //in case payment operation is not successful
            return redirect('/payment')->withErrors([$this->payment->paymentErrorMessage]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verify(Request $request){
        //check if payment operation has been done!
        if($request->status === Payir::SUCCESSFUL_STATUS)
        {
            $verify_result = $this->payment->verify($request);

            if($verify_result){
                $verify_status = 'committed';
            }
            else{
                $verify_status = 'failed';
                $error_message = $this->payment->verifyErrorMessage;
            }
        }
        else
        {
            $verify_status = 'failed';
            $error_message = $request->message;
        }

        if($verify_status == 'committed'){
            return redirect('/payment')->with('message',__('messages.Payment has done successfully.'));
        }
        else {
            return redirect('/payment')->withErrors([$error_message]);
        }
    }
}
```
