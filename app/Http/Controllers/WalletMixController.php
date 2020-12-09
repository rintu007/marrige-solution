<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Mail;
use Carbon\Carbon;
use App\Model\User;
use App\Model\Page;
use App\Model\AdSpace;
use App\Model\Upazila;
use GuzzleHttp\Client;
use App\Model\Division;
use App\Model\District;
use App\Model\walletmix;
use App\Model\FrontSlider;
use App\Model\UserPayment;
use App\Model\PostDivision;
use App\Model\PostCategory;
use App\Model\PostDistrict;
use App\Model\Blog as Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Model\BlogTag as Tag;
use App\Model\SuccessProfile;
use App\Model\UserContactInfo;
use App\Model\UsersForAutoMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Model\BlogCategory as Category;
use GuzzleHttp\Exception\GuzzleException;

class WalletMixController extends Controller
{
    public function __construct()
    {
      
    }

    public function paytoPaymentGateway(UserPayment $payment)
    {
      if($payment->status != 'pending')
      {
          return redirect('/');
      }

      // include ('walletmix.php');
 
      // $walletmix = NEW walletmix('access_username', 'access_password', 'merchant_id','access_app_key');




      

      $walletmix = NEW walletmix('taslima12_1430222877', 'taslima12_1450641174', 'WMX594e06a8b763c','dd9fa79a0d7dbe7c924ca99b69405315352db889');


/*
"id" => 22
"status" => "pending"
"membership_package_id" => 2
"package_title" => "Golden Plus (Bangladesh)"
"package_description" => "Three Months Membership for Bangladeshi Peoples"
"package_amount" => "4500.00"
"package_currency" => "BDT"
"package_duration" => "90"
"paid_amount" => "4000.00"
"paid_currency" => "BDT"
"payment_method" => "bKash"
"payment_details" => "asdfsd asdfasdf"
"admin_comment" => null
"user_id" => 1
"addedby_id" => 1
"editedby_id" => null
"created_at" => "2018-10-26 04:50:45"
"updated_at" => "2018-10-26 04:50:45"




//output after payment 

stdClass Object
(
    [wmx_id] => WMX594e06a8b763c
    [ref_id] => iz4TR5hVkzJWQFW
    [token] => a3940e46843dae2037aacfb98b1c5bf2b57e0033
    [merchant_req_amount] => 10.00
    [merchant_ref_id] => 5bd2e44b3baaf
    [merchant_currency] => BDT
    [merchant_amount_bdt] => 10.00
    [conversion_rate] => 1.00
    [service_ratio] => 2.00
    [wmx_charge_bdt] => 0.20
    [emi_ratio] => 0.00
    [emi_charge] => 0.00
    [bank_amount_bdt] => 11.00
    [discount_bdt] => 0.00
    [merchant_order_id] => 120
    [request_ip] => 58.145.188.238
    [txn_status] => 1000
    [extra_json] => []
    [txn_details] => 
    [card_details] => 01918515567
    [is_foreign] => 0
    [payment_card] => BKASH-bKash
    [card_code] => 6001
    [payment_method] => 5005
    [init_time] => 2018-10-26 15:54:20
    [txn_time] => 2018-10-26 15:54:28
)

*/

$product = $payment;
$user = $payment->user;

if($user->country == 'Other' || $user->country == 'Others')
{
  $country = $user->country_other;
}
else
{
  $country = $user->country;
}


       
      $customer_info = array(
          "customer_name"     => $user->name,
          "customer_email"    => $user->email,
          "customer_add"      => "User ID: ". $payment->user_id . ", User Email: ". $user->email . ", User Mobile: " . $user->mobile,
          "customer_city"     => "",
          "customer_country"  => $country,
          "customer_postcode" => "",
          "customer_phone"    => $user->mobile,
      );
      $shipping_info = array(
          "shipping_name" => $user->name,
          "shipping_add" => "User ID: ". $payment->user_id . ", User Email: ". $user->email . ", User Mobile: " . $user->mobile,
          "shipping_city" => "",
          "shipping_country" => $country,
          "shipping_postCode" => "",
      );
      $walletmix->set_shipping_charge(0);
      $walletmix->set_discount(0);
       
      // $product_1 = array('name' => 'Adata 16GB Pendrive','price' => 5,'quantity' => 2);
      // $product_2 = array('name' => 'Adata 8GB Pendrive','price' => 5,'quantity' => 1);
       
      // $products = array($product_1,$product_2);

      
       
      $walletmix->set_product_description($product);
       
      $walletmix->set_merchant_order_id($payment->id);
      $walletmix->set_currency($payment->package_currency);
       
      $walletmix->set_app_name('taslimamarriagemedia.com');
      $walletmix->set_callback_url(route('welcome.paytoPaymentGatewayCallback'));
       
      $extra_data = array();
       
      //if you want to send extra data then use this way
      //$extra_data = array('param_1' => 'data_1','param_2' => 'data_2','param_3' => 'data_3');
       
      $walletmix->set_extra_json($extra_data);
       
      $walletmix->set_transaction_related_params($customer_info);
      $walletmix->set_transaction_related_params($shipping_info);
       
      $walletmix->set_database_driver('session'); // options: "txt" or "session"
       
      $walletmix->send_data_to_walletmix($payment);
    }

    public function paytoPaymentGatewayCallback()
    {

      $walletmix = NEW walletmix('taslima12_1430222877', 'taslima12_1450641174', 'WMX594e06a8b763c','dd9fa79a0d7dbe7c924ca99b69405315352db889');
 
      $walletmix->set_database_driver('session'); // options: "txt" or "session"
       
      if(isset($_POST['merchant_txn_data'])){
          $merchant_txn_data = json_decode($_POST['merchant_txn_data']);
         
          $walletmix->get_database_driver();
         
          if($walletmix->get_database_driver() == 'txt'){
              $saved_data = json_decode($walletmix->read_file());
          }elseif($walletmix->get_database_driver() == 'session'){
              // Read data from your database
              $saved_data = json_decode($walletmix->read_data());
          }
         
          // if($merchant_txn_data->token === $saved_data->token){
          // dd(request()->session()->get('wmx_token'));

           $wmx_response = json_decode($walletmix->check_payment($saved_data));

          $payment = UserPayment::find($wmx_response->merchant_order_id);

          if($merchant_txn_data->token === $payment->wm_token)
          {
             
              // $wmx_response = json_decode($walletmix->check_payment($saved_data));
              // $walletmix->debug($wmx_response,true);
              if( ($wmx_response->wmx_id == $saved_data->wmx_id) ){
                  if( ($wmx_response->txn_status == '1000') ){
                      
                      // if( ($wmx_response->bank_amount_bdt >= $saved_data->amount) ){

                      if( $wmx_response->bank_amount_bdt >= $payment->package_amount ){


                        
                        if($payment)
                        {

                          $payment->status = 'paid';

                          $payment->paid_amount = $wmx_response->merchant_req_amount;

                          $payment->paid_currency = $wmx_response->merchant_currency;

                          $payment->payment_method = "Payment Card: ".$wmx_response->payment_card . ", Payment Method: " . $wmx_response->payment_method;
                          $payment->payment_details = "Payable Ammount: BDT" .$wmx_response->merchant_amount_bdt . ", Gateway Charge: " . $wmx_response->service_ratio . "%, Total Paid To Bank BDT " . $wmx_response->bank_amount_bdt . ". Payment ID: " . $wmx_response->merchant_order_id. ", Card Details: " . $wmx_response->card_details;
                          $payment->admin_comment = null;
                          $payment->editedby_id = Auth::id();
                          $payment->updated_at = Carbon::now();
                          $payment->save();

                          $user = $payment->user;
                          $user->package = $payment->membership_package_id;
                          $expired_at = $user->expired_at;
                          if($expired_at > Carbon::now())
                          {
                              $user->expired_at = $expired_at->addDays($payment->package_duration);
                          }else
                          {
                              $user->expired_at = Carbon::now()->addDays($payment->package_duration);
                          }

                          $user->save();


                          if(!(env('APP_ENV') == 'local'))
                          {  
                              Mail::send('emails.paymentAcceptedToUser', ['payment'=>$payment], function ($message) use ($payment){
                                  $message->from('mail@taslimamarriagemedia.com', 'T M Media Payment Section');
                                  $message->to($payment->user->email,  '')
                                  ->subject('Payment Accepted at '.url('/'));
                              });
                          }

                          ### sms api end here (masking & nonmasking seperate) ###

                              $masking = smsMaskingCode();
                              $to = '8801782006615';
                              $username = 'taslimamedia@gmail.com';
                              $pass = '01719369717';
                              $apiKey = smsApiKey();
                              $msg = 'Hello Admin, New payment details: Amount: ' . $payment->paid_amount . ' ' . $payment->paid_currency . '. Package ID: ' . $payment->membership_package_id . '. User:'. $user->email;  
                              
                              $url = "http://connect.primesoftbd.com/smsapi/masking?api_key={$apiKey}&smsType=text&maskingID={$masking}&mobileNo={$to}&smsContent={$msg}"; 


                               $client = new Client();
                               //https://stackoverflow.com/questions/46005027/handling-client-errors-exceptions-on-guzzlehttp            
                              try {
                                      $r = $client->request('GET', $url);
                                  } catch (\GuzzleHttp\Exception\ConnectException $e) {
                                      // This is will catch all connection timeouts
                                      // Handle accordinly
                                  } catch (\GuzzleHttp\Exception\ClientException $e) {
                                      // This will catch all 400 level errors.
                                      // return $e->getResponse()->getStatusCode();
                                  }
                              ### sms api end here (masking & nonmasking seperate) ###

                          return redirect('/')->with('success', 'Payment info successfully updated.');
                        }



                          // if( ($wmx_response->merchant_amount_bdt == $saved_data->amount) ){ 

                              

                            
                          //     echo 'Update merchant database with success. amount : '.$wmx_response->bank_amount_bdt;


                          // }else{
                          //     echo 'Merchant amount mismatch Merchant Amount : '.$saved_data->amount.' Bank Amount : '.$wmx_response->bank_amount_bdt.'. Update merchant database with success';
                          // }

                      }else{
                          echo 'Bank amount is less then merchant amount like partial payment.Failed transaction.';
                      }
                  }else{
                      echo 'Updated merchant database with failed';
                  }
              }else{
                  echo 'Merchant ID Mismatch';
              }
          }else{
              echo 'Token mismatch';
          }
      }else{
          echo 'Try to direct access';
      }

      
    }

}
