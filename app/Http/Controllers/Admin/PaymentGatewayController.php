<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileManager;
use App\Models\Gateway;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    public function paypal()
    {
        $data['pageTitle'] = 'Paypal Payment';
        $data['subNavPaypalActiveClass'] = 'active';
        $data['gateway'] = Gateway::where('gateway_name', 'paypal')->first();
        return view('admin.gateways.paypal')->with($data);
    }

    public function paypalUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'paypal')->first();
        if (!$gateway) {
            $gateway = new Gateway();
        }
        $gateway->gateway_name = 'paypal';
        $gateway->gateway_currency = $request->gateway_currency;
        $gateway_parameters = [
            'mode' => $request->mode,
            'paypal_client_id' => $request->paypal_client_id,
            'paypal_secret' => $request->paypal_secret,
        ];
        $gateway->gateway_parameters = $gateway_parameters;
        $gateway->gateway_type = 2; // 2 means online payment
        $gateway->conversion_rate = $request->conversion_rate;
        $gateway->status = $request->status;
        $gateway->wallet_gateway_status = $request->wallet_gateway_status;
        $gateway->save();
        /*File Manager Call upload*/
        if ($request->hasFile('image')) {
            $new_file = FileManager::where('origin_type', 'App\Models\Gateway')->where('origin_id', $gateway->id)->first();

            if ($new_file) {
                $new_file->removeFile();
                $upload = $new_file->updateUpload($new_file->id, 'Gateway', $request->image);
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('Gateway', $request->image);
            }
            if (@$upload->code != 100) {
                $upload->origin_id = $gateway->id;
                $upload->origin_type = "App\Models\Gateway";
                $upload->save();
            }
        }
        /*End*/
        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function stripe()
    {
        $data['pageTitle'] = 'Stripe Payment';
        $data['subNavStripeActiveClass'] = 'active';
        $data['gateway'] = Gateway::where('gateway_name', 'stripe')->first();
        return view('admin.gateways.stripe')->with($data);
    }

    public function stripeUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'stripe')->first();
        if (!$gateway) {
            $gateway = new Gateway();
        }
        $gateway->gateway_name = 'stripe';
        $gateway->gateway_currency = $request->gateway_currency;

        $gateway_parameters = [
            'mode' => $request->mode,
            'stripe_public_key' => $request->stripe_public_key,
            'stripe_secret_key' => $request->stripe_secret_key,
        ];
        $gateway->gateway_parameters = $gateway_parameters;

        $gateway->gateway_type = 2; // 2 means online payment
        $gateway->conversion_rate = $request->conversion_rate;
        $gateway->status = $request->status;
        $gateway->wallet_gateway_status = $request->wallet_gateway_status;
        $gateway->save();

        /*File Manager Call upload*/
        if ($request->hasFile('image')) {
            $new_file = FileManager::where('origin_type', 'App\Models\Gateway')->where('origin_id', $gateway->id)->first();
            if ($new_file) {
                $new_file->removeFile();
                $upload = $new_file->updateUpload($new_file->id, 'Gateway', $request->image);
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('Gateway', $request->image);
            }
            if (@$upload->code != 100) {
                $upload->origin_id = $gateway->id;
                $upload->origin_type = "App\Models\Gateway";
                $upload->save();
            }
        }
        /*End*/
        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function razorpay()
    {
        $data['pageTitle'] = 'Razorpay Payment';
        $data['subNavRazorpayActiveClass'] = 'active';
        $data['gateway'] = Gateway::where('gateway_name', 'razorpay')->first();
        return view('admin.gateways.razorpay')->with($data);
    }

    public function razorpayUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'razorpay')->first();
        if (!$gateway) {
            $gateway = new Gateway();
        }
        $gateway->gateway_name = 'razorpay';
        $gateway->gateway_currency = $request->gateway_currency;

        $gateway_parameters = [
            'razorpay_key' => $request->razorpay_key,
            'razorpay_secret' => $request->razorpay_secret,
        ];
        $gateway->gateway_parameters = $gateway_parameters;

        $gateway->gateway_type = 2; // 2 means online payment
        $gateway->conversion_rate = $request->conversion_rate;
        $gateway->status = $request->status;
        $gateway->save();

        /*File Manager Call upload*/
        if ($request->hasFile('image')) {
            $new_file = FileManager::where('origin_type', 'App\Models\Gateway')->where('origin_id', $gateway->id)->first();
            if ($new_file) {
                $new_file->removeFile();
                $upload = $new_file->updateUpload($new_file->id, 'Gateway', $request->image);
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('Gateway', $request->image);
            }
            if (@$upload->code != 100) {
                $upload->origin_id = $gateway->id;
                $upload->origin_type = "App\Models\Gateway";
                $upload->save();
            }
        }
        /*End*/
        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function instamojo()
    {
        $data['pageTitle'] = 'Instamojo Payment';
        $data['subNavInstamojoActiveClass'] = 'active';
        $data['gateway'] = Gateway::where('gateway_name', 'instamojo')->first();
        return view('admin.gateways.instamojo')->with($data);
    }

    public function instamojoUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'instamojo')->first();
        if (!$gateway) {
            $gateway = new Gateway();
        }
        $gateway->gateway_name = 'instamojo';
        $gateway->gateway_currency = $request->gateway_currency;
        $gateway_parameters = [
            'mode' => $request->mode,
            'instamojo_api_key' => $request->instamojo_api_key,
            'instamojo_auth_token' => $request->instamojo_auth_token,
            'frontend_redirect_url' => $request->frontend_redirect_url
        ];
        $gateway->gateway_parameters = $gateway_parameters;

        $gateway->gateway_type = 2; // 2 means online payment
        $gateway->conversion_rate = $request->conversion_rate;
        $gateway->status = $request->status;
        $gateway->save();
        /*File Manager Call upload*/
        if ($request->hasFile('image')) {
            $new_file = FileManager::where('origin_type', 'App\Models\Gateway')->where('origin_id', $gateway->id)->first();

            if ($new_file) {
                $new_file->removeFile();
                $upload = $new_file->updateUpload($new_file->id, 'Gateway', $request->image);
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('Gateway', $request->image);
            }

            if (@$upload->code != 100) {
                $upload->origin_id = $gateway->id;
                $upload->origin_type = "App\Models\Gateway";
                $upload->save();
            }
        }
        /*End*/
        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function mollie()
    {
        $data['pageTitle'] = 'Mollie Payment';
        $data['subNavMollieActiveClass'] = 'active';
        $data['gateway'] = Gateway::where('gateway_name', 'mollie')->first();
        return view('admin.gateways.mollie')->with($data);
    }

    public function mollieUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'mollie')->first();
        if (!$gateway) {
            $gateway = new Gateway();
        }
        $gateway->gateway_name = 'mollie';
        $gateway->gateway_currency = $request->gateway_currency;

        $gateway_parameters = [
            'mollie_key' => $request->mollie_key,
            'frontend_redirect_url' => $request->frontend_redirect_url
        ];

        $gateway->gateway_parameters = $gateway_parameters;
        $gateway->gateway_type = 2; // 2 means online payment
        $gateway->conversion_rate = $request->conversion_rate;
        $gateway->status = $request->status;
        $gateway->save();

        /*File Manager Call upload*/
        if ($request->hasFile('image')) {
            $new_file = FileManager::where('origin_type', 'App\Models\Gateway')->where('origin_id', $gateway->id)->first();
            if ($new_file) {
                $new_file->removeFile();
                $upload = $new_file->updateUpload($new_file->id, 'Gateway', $request->image);
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('Gateway', $request->image);
            }
            if (@$upload->code != 100) {
                $upload->origin_id = $gateway->id;
                $upload->origin_type = "App\Models\Gateway";
                $upload->save();
            }
        }
        /*End*/
        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function paystack()
    {
        $data['pageTitle'] = 'Paystack Payment';
        $data['subNavPaystackActiveClass'] = 'active';
        $data['gateway'] = Gateway::where('gateway_name', 'paystack')->first();
        return view('admin.gateways.paystack')->with($data);
    }

    public function paystackUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'paystack')->first();
        if (!$gateway) {
            $gateway = new Gateway();
        }
        $gateway->gateway_name = 'paystack';
        $gateway->gateway_currency = $request->gateway_currency;
        $gateway_parameters = [
            'paystack_public_key' => $request->paystack_public_key,
            'paystack_secret_key' => $request->paystack_secret_key,
        ];
        $gateway->gateway_parameters = $gateway_parameters;

        $gateway->gateway_type = 2; // 2 means online payment
        $gateway->conversion_rate = $request->conversion_rate;
        $gateway->status = $request->status;
        $gateway->save();

        /*File Manager Call upload*/
        if ($request->hasFile('image')) {
            $new_file = FileManager::where('origin_type', 'App\Models\Gateway')->where('origin_id', $gateway->id)->first();
            if ($new_file) {
                $new_file->removeFile();
                $upload = $new_file->updateUpload($new_file->id, 'Gateway', $request->image);
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('Gateway', $request->image);
            }
            if (@$upload->code != 100) {
                $upload->origin_id = $gateway->id;
                $upload->origin_type = "App\Models\Gateway";
                $upload->save();
            }
        }
        /*End*/
        return redirect()->back()->with('success', __('Updated successfully'));
    }

    public function sslcommerz()
    {
        $data['pageTitle'] = 'SSLCOMMERZ Payment';
        $data['subNavSSLCOMMERZActiveClass'] = 'active';
        $data['gateway'] = Gateway::where('gateway_name', 'sslcommerz')->first();
        return view('admin.gateways.sslcommerz')->with($data);
    }

    public function sslcommerzUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'sslcommerz')->first();
        if (!$gateway) {
            $gateway = new Gateway();
        }
        $gateway->gateway_name = 'sslcommerz';
        $gateway->gateway_currency = $request->gateway_currency;

        $gateway_parameters = [
            'mode' => $request->mode,
            'store_id' => $request->store_id,
            'store_password' => $request->store_password,
            'frontend_redirect_url' => $request->frontend_redirect_url
        ];
        $gateway->gateway_parameters = $gateway_parameters;

        $gateway->gateway_type = 2; // 2 means online payment
        $gateway->conversion_rate = $request->conversion_rate;
        $gateway->status = $request->status;
        $gateway->save();

        /*File Manager Call upload*/
        if ($request->hasFile('image')) {
            $new_file = FileManager::where('origin_type', 'App\Models\Gateway')->where('origin_id', $gateway->id)->first();
            if ($new_file) {
                $new_file->removeFile();
                $upload = $new_file->updateUpload($new_file->id, 'Gateway', $request->image);
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('Gateway', $request->image);
            }
            if (@$upload->code != 100) {
                $upload->origin_id = $gateway->id;
                $upload->origin_type = "App\Models\Gateway";
                $upload->save();
            }
        }
        /*End*/
        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function bank()
    {
        $data['pageTitle'] = 'Bank Payment';
        $data['subNavBankActiveClass'] = 'active';
        $data['gateway'] = Gateway::where('gateway_name', 'bank')->first();
        return view('admin.gateways.bank')->with($data);
    }

    public function bankUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'bank')->first();
        if (!$gateway) {
            $gateway = new Gateway();
        }
        $gateway->gateway_name = 'bank';
        $gateway->gateway_currency = $request->gateway_currency;
        $gateway_parameters = [
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_routing_number' => $request->bank_routing_number,
            'bank_branch_name' => $request->bank_branch_name,
        ];
        $gateway->gateway_parameters = $gateway_parameters;
        $gateway->gateway_type = 1; // 1 means manual payment
        $gateway->conversion_rate = $request->conversion_rate;
        $gateway->status = $request->status;
        $gateway->wallet_gateway_status = $request->wallet_gateway_status;
        $gateway->save();
        /*File Manager Call upload*/
        if ($request->hasFile('image')) {
            $new_file = FileManager::where('origin_type', 'App\Models\Gateway')->where('origin_id', $gateway->id)->first();

            if ($new_file) {
                $new_file->removeFile();
                $upload = $new_file->updateUpload($new_file->id, 'Gateway', $request->image);
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('Gateway', $request->image);
            }
            if (@$upload->code != 100) {
                $upload->origin_id = $gateway->id;
                $upload->origin_type = "App\Models\Gateway";
                $upload->save();
            }
        }
        /*End*/
        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function wallet()
    {
        $data['pageTitle'] = 'Wallet Payment';
        $data['subNavWalletActiveClass'] = 'active';
        $data['gateway'] = Gateway::where('gateway_name', 'wallet')->first();
        return view('admin.gateways.wallet')->with($data);
    }

    public function walletUpdate(Request $request)
    {
        $gateway = Gateway::where('gateway_name', 'wallet')->first();
        if (!$gateway) {
            $gateway = new Gateway();
        }
        $gateway->gateway_name = 'wallet';
        $gateway->gateway_currency = getIsoCode();
        $gateway->gateway_type = 3; // 3 means wallet payment
        $gateway->conversion_rate = 1;
        $gateway->status = $request->status;
        $gateway->save();

        /*File Manager Call upload*/
        if ($request->hasFile('image')) {
            $new_file = FileManager::where('origin_type', 'App\Models\Gateway')->where('origin_id', $gateway->id)->first();

            if ($new_file) {
                $new_file->removeFile();
                $upload = $new_file->updateUpload($new_file->id, 'Gateway', $request->image);
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('Gateway', $request->image);
            }
            if (@$upload->code != 100) {
                $upload->origin_id = $gateway->id;
                $upload->origin_type = "App\Models\Gateway";
                $upload->save();
            }
        }
        /*End*/
        return redirect()->back()->with('success', __('Updated Successfully'));
    }

}
