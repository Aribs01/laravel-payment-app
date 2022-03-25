<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Models\Deposit;
use Illuminate\Support\Facades\Redirect;
use Paystack;

class AppController extends Controller
{
    public function apiDoc() {
        return view ('apidoc');
    }

    public function dashboard() {
        $deposits = Deposit::all();
        echo "DASHBOARD";
        echo "All Deposit Details as:";
        echo $deposits;
    }

    public function deposit() {

        $deposits = Deposit::all();
        echo "DEPOSIT PAGE";
        echo "_token as :";
        echo csrf_token();
        echo "All Deposit Details as :";
        echo $deposits;
    }

    public function createdeposit(Request $request) {

        $deposits = new Deposit();
        $deposits->amount = $request->amount;
        $deposits->save();
    }

    public function viewdeposit($id) {

        $deposit = Deposit::findOrFail($id);
        echo "ID as";
        echo $id;
        echo "Deposit Details as :";
        echo $deposit;
        
    }

    public function redirectToGateway(Request $request) {
        try {
            return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (\Exception $e) {
            return Redirect::back()
            ->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 
            'type'=>'error']);
        }
    }

    public function gatewayCallback()
    {
        //Get Authenticated User
        // $id = Auth::id();
        
        $paymentDetails = Paystack::getPaymentData();
        $inv_id = $paymentDetails['data']['metadata']['invoiceId'];
        $status = $paymentDetails['data']['status'];
        $amount = $paymentDetails['data']['status'];
        $number = $randnum = rand(111111111,999999999);
        $number = 'year'.$number;

        if($status == "success"){
            // Payment::create(['amount' => $amount]);
            $deposits = new Deposit();
            $deposits->amount = $amount;
            $deposits->save();
        // echo $amount;
        echo "GOT HERE";
        }
    }
}
