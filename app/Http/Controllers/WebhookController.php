<?php

namespace App\Http\Controllers;

use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use App\Invoices;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends CashierController
{
    /**
     * Handle a Stripe webhook.
     *
     * @param  array  $payload
     * @return Response
     */

    

    public function handleInvoicePaymentSucceeded( array $payload)
    {
       $invoiceID = $payload['data']['object']['id'];
       $customerID = $payload['data']['object']['customer'];
       $subscriptionID = $payload['data']['object']['subscription'];
       $status = $payload['data']['object']['paid'];
       if ($status){
        $saveStatus = "Paid";
       } else {
        $saveStatus = "Unpaid";
       }
      // echo "<pre>"; print_r($payload); die;
        $invoiceSave = Invoices::create([
                  'invoice_id'      =>$invoiceID,
                  'subscription_id'  =>$subscriptionID,
                  'cus_id'          =>$customerID,
                  'status'          =>$saveStatus
            ]);
       return new Response('Webhook Handled', 200);
    }

     public function  handleInvoicePaymentFailed(array $payload)
     {
      $invoiceID = $payload['data']['object']['id'];
       $customerID = $payload['data']['object']['customer'];
       $subscriptionID = $payload['data']['object']['subscription'];
       $status = $payload['data']['object']['paid'];
       if ($status){
        $saveStatus = "Paid";
       } else {
        $saveStatus = "Faild";
       }
      // echo "<pre>"; print_r($payload); die;
        $invoiceSave = Invoices::create([
                  'invoice_id'      =>$invoiceID,
                  'subscription_id'  =>$subscriptionID,
                  'cus_id'          =>$customerID,
                  'status'          =>$saveStatus
            ]);
      return new Response('Webhook Handled', 200);
     }


     /*public function  handleInvoicePaymentFailed(array $payload)

     public function  handleInvoicePaymentFailed(array $payload)
     {
      $invoiceID = $payload['data']['object']['id'];
       $customerID = $payload['data']['object']['customer'];
       $subscriptionID = $payload['data']['object']['subscription'];
       $status = $payload['data']['object']['paid'];
       if ($status){
        $saveStatus = "Paid";
       } else {
        $saveStatus = "Faild";
       }
      // echo "<pre>"; print_r($payload); die;
        $invoiceSave = Invoices::create([
                  'invoice_id'      =>$invoiceID,
                  'subscription_id'  =>$subscriptionID,
                  'cus_id'          =>$customerID,
                  'status'          =>$saveStatus
            ]);
      return new Response('Webhook Handled', 200);

     }*/

     }

}