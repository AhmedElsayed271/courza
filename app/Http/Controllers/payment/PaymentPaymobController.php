<?php

namespace App\Http\Controllers\payment;

use App\Models\User;
use App\Models\Order;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\UserBuyCourse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\RequiredIf;

class PaymentPaymobController extends Controller
{
    public function PayByPaymob(Request $request)
    {

        $validate = $request->validate([
            'paymentMethod' => 'required|in:wallet,credit',
            'phone' => ['nullable','required_if:paymentMethod,wallet','numeric'],
        ],[
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.required_if' => 'اذا كنت سوف تدفع عن طربقة المحفظة فيجب عليك ادخال رقم المحفظة',
            'phone.min' => 'رقم الهاتف يجب الا يقل عن 11 حرف',
            'phone.max' => 'رقم الهاتف يجب الا يزيد عن 11 حرف',
            'phone.numeric' => 'هذا الحقل يجب ان يكون رقما',
            'paymentMethod.required' => 'يجب تحديد طربقة الدفع ',
        ]);


        $course = Course::findOrFail($request->course_id);

        $user = Auth::guard('web')->user();

        $checkifUserbuyCourse = UserBuyCourse::where(['user_id' => $user->id,'course_id' => $course->id])->first();

        if (!empty($checkifUserbuyCourse))
        {
            return redirect()->back()->with(['error' => 'لقد اشتريت هذا الكوبس بالفعل']);
        }

        if ($request->buyBy && !empty($request->buyBy)) {


            $user = User::find($request->buyBy);

            if (!$user) {
                return redirect()->route('home');
            }

            Cookie::queue('marketingBy', $request->buyBy, 60 * 24 * 30);

          
          
        }

        $marketingBy = Cookie::get('marketingBy');


        if ($request->paymentMethod == 'credit') {

            $integration_id_card = config('services.paymob.integration_id_card');

            $response = $this->paymentStepsIntegration($course, $user, $integration_id_card);

            $token = $response['token'];
 
           

            Order::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'price' =>  $course->price,
                'currency' =>  "EGP",
                'order_id' =>  $response['order_id'],
                'buyBy' =>  $marketingBy,
            ]);
            return view('payment.payByCredit', compact('token'));
        }

        $response = $this->PayByWallet($course, $user, $request->phone);

        Order::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'price' =>  $course->price,
            'order_id' =>  $response['order_id'],
            'buyBy' =>  $marketingBy,
        ]);

        if (!$response['redirect_url']) {
            return redirect()->back()->with(['error' => 'هذا الرقم غير صحيح او لا يحتوي على محفظة']);
        }

        return Redirect::to($response['redirect_url']);
    }


    public function paymentStepsIntegration($course, $user, $integration_id)
    {
        
        $apiKey = config('services.paymob.api_key');

        $response = Http::withHeaders([

            "Content-Type" => "application/json",

        ])->post('https://accept.paymob.com/api/auth/tokens', [
            'api_key' => $apiKey,
        ]);

        $token = $response['token'];

        $response = Http::withHeaders([

            "Content-Type" => "application/json",

        ])->post('https://accept.paymob.com/api/ecommerce/orders', [
            'auth_token' => $token,
            'delivery_needed' => 'false',
            'amount_cents' => $course->price * 100,
            "currency" => "EGP",
            "items" => []
        ]);

        $id = $response['id'];
    
        $response = Http::withHeaders([

            "Content-Type" => "application/json",

        ])->post('https://accept.paymob.com/api/acceptance/payment_keys', [
            'auth_token' => $token,
            'amount_cents' => $course->price * 100,
            "expiration" => 3600,
            "order_id" => $id,
            "currency" => "EGP",
            'billing_data' => [
                "apartment" => "803",
                "email" => $user->email,
                "floor" => "NA",
                "first_name" => $user->first_name ?? "mohammed",
                "street" => "NA",
                "building" => "NA",
                "phone_number" => $user->phone ?? "",
                "shipping_method" => "NA",
                "postal_code" => "NA",
                "city" => "NA",
                "country" => "NA",
                "last_name" => $user->last_name ?? "ahmed",
                "state" => "NA"
            ],
            "integration_id" => $integration_id,
            "lock_order_when_paid" => "false"

        ]);

        $response;

        $token = $response['token'];

        return ['token' => $token, 'order_id' => $id];
    }

    public function PayByWallet($course, $user, $phone)
    {
        $integration_id_wallet = config('services.paymob.integration_id_wallet');

        $response = $this->paymentStepsIntegration($course, $user, $integration_id_wallet);

        $token = $response['token'];

        $order_id = $response['order_id'];

        $response = Http::withHeaders([

            "Content-Type" => "application/json",

        ])->post('https://accept.paymob.com/api/acceptance/payments/pay', [
            'source' => [
                "identifier" => $phone,
                "subtype" => "WALLET"
            ],
            'payment_token' => $token,

        ]);

        return ['redirect_url' => $response['redirect_url'], 'order_id' => $order_id];
    }

    public function state(Request $request)
    {
        return redirect()->route('profile.index');
    }

    function paymobCallback(Request $request)
    {



        
        $amount_cents                           = $request['obj']['amount_cents'];
        $created_at                             = $request['obj']['created_at'];
        $currency                               = $request['obj']['order']['currency'];
        $error_occured                          = $request['obj']['error_occured'] ? 'true' : 'false';
        $has_parent_transaction                 = $request['obj']['has_parent_transaction'] ? 'true' : 'false';
        $obj_id                                 = $request['obj']['id'];
        $integration_id                         = $request['obj']['integration_id'];
        $is_3d_secure                           = $request['obj']['is_3d_secure'] ? 'true' : 'false';
        $is_auth                                = $request['obj']['is_auth'] ? 'true' : 'false';
        $is_capture                             = $request['obj']['is_capture'] ? 'true' : 'false';
        $is_refunded                            = $request['obj']['is_refunded'] ? 'true' : 'false';
        $is_standalone_payment                  = $request['obj']['is_standalone_payment'] ? 'true' : 'false';
        $is_voided                              = $request['obj']['is_voided'] ? 'true' : 'false';
        $order_id                               = $request['obj']['order']['id'];
        $owner                                  = $request['obj']['owner'];
        $pending                                = $request['obj']['pending'] ? 'true' : 'false';
        $source_data_pan                        = $request['obj']['source_data']['pan'];
        $source_data_sub_type                   = $request['obj']['source_data']['sub_type'];
        $source_data_type                       = $request['obj']['source_data']['type'];
        $success                                = $request['obj']['success'];

        $isSecure = $this->calculateHash($request);

        if ($isSecure) {

            if ($success) {

                $order = Order::where('order_id', $order_id)->first();
                $order->update([
                    'transaction_id' => $obj_id,
                    'payment_method' => 'paymob',
                    'payment_type' =>  $source_data_type,
                    'status' => 'success',
                ]);
    
                if ($order->buyBy != null) {
    
                    $user = User::find($order->buyBy);
                    $rate = 20 / 100;
    
                    $increment = $rate * $order->price;
    
                    $user->increment('wallet', $increment);
                }

                UserBuyCourse::create([
                    'user_id' => $order->user_id,
                    'course_id' => $order->course_id,
                ]);

                return $order;

            } else {
                $order = Order::where('order_id', $order_id)->first();
                $order->update([
                    'transaction_id' => $obj_id,
                    'payment_method' => 'paymob',
                    'payment_type' =>  $source_data_type,
                    'status' => 'failed',
                ]);
            }
   


        }

        Log::debug($success);

    
    }

    private function calculateHash($json)
    {
        if (!$json) return false;

        $amount_cents                           = $json['obj']['amount_cents'];
        $created_at                             = $json['obj']['created_at'];
        $currency                               = $json['obj']['order']['currency'];
        $error_occured                          = $json['obj']['error_occured'] ? 'true' : 'false';
        $has_parent_transaction                 = $json['obj']['has_parent_transaction'] ? 'true' : 'false';
        $obj_id                                 = $json['obj']['id'];
        $integration_id                         = $json['obj']['integration_id'];
        $is_3d_secure                           = $json['obj']['is_3d_secure'] ? 'true' : 'false';
        $is_auth                                = $json['obj']['is_auth'] ? 'true' : 'false';
        $is_capture                             = $json['obj']['is_capture'] ? 'true' : 'false';
        $is_refunded                            = $json['obj']['is_refunded'] ? 'true' : 'false';
        $is_standalone_payment                  = $json['obj']['is_standalone_payment'] ? 'true' : 'false';
        $is_voided                              = $json['obj']['is_voided'] ? 'true' : 'false';
        $order_id                               = $json['obj']['order']['id'];
        $owner                                  = $json['obj']['owner'];
        $pending                                = $json['obj']['pending'] ? 'true' : 'false';
        $source_data_pan                        = $json['obj']['source_data']['pan'];
        $source_data_sub_type                   = $json['obj']['source_data']['sub_type'];
        $source_data_type                       = $json['obj']['source_data']['type'];
        $success                                = $json['obj']['success'] ? 'true' : 'false';


        $str = $amount_cents . $created_at . $currency . $error_occured . $has_parent_transaction . $obj_id . $integration_id . $is_3d_secure . $is_auth . $is_capture . $is_refunded . $is_standalone_payment . $is_voided . $order_id . $owner . $pending . $source_data_pan . $source_data_sub_type . $source_data_type . $success;

        $secure_hash = $json->hmac;

        $hmac_code = config('services.paymob.hmac');

        $hamc = hash_hmac('sha512', $str, $hmac_code);

        return $hamc == $secure_hash ? true : false;
    }
}
