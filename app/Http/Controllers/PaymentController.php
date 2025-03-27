<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SSLCommerz\SSLCommerz\Facades\SSLCommerz;

class PaymentController extends Controller
{
    public function payViaSSLCommerz(Request $request)
    {
        # Here you have all the necessary input from the customer to make the payment.
        # Please do not forget to insert the order data into your database so that you can
        # match it with the payment response.

        $post_data = array();
        $post_data['total_amount'] = $request->amount; # You can't change the value after submitting to SSLCommerz.
        $post_data['currency'] = 'BDT';
        $post_data['tran_id'] = uniqid(); # Unique transaction id
        $post_data['success_url'] = route('payment.success');
        $post_data['fail_url'] = route('payment.fail');
        $post_data['cancel_url'] = route('payment.cancel');
        # $post_data['multi_card_name'] = 'mastercard,visacard,amexcard';  # If you have multi card option
        # $post_data['allowed_bin'] = '371598,379598,414173,'; # Uncomment if you have specific BIN/Card range

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->customer_name;
        $post_data['cus_email'] = $request->customer_email;
        $post_data['cus_add1'] = 'Customer Address 1';
        $post_data['cus_city'] = 'Dhaka';
        $post_data['cus_postcode'] = '1207';
        $post_data['cus_country'] = 'BD';
        $post_data['cus_phone'] = $request->customer_phone;
        # $post_data['cus_fax'] = '01711111111';

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = 'Shipping Name';
        $post_data['ship_add1 '] = 'Shipping Address 1';
        $post_data['ship_city'] = 'Dhaka';
        $post_data['ship_postcode'] = '1207';
        $post_data['ship_country'] = 'BD';

        $post_data['shipping_method'] = 'NO'; # Courier
        $post_data['product_name'] = 'Computer';
        $post_data['product_category'] = 'Electronics';
        $post_data['product_profile'] = 'general';

        # OPTIONAL PARAMETERS
        # $post_data['value_a'] = "ref001";
        # $post_data['value_b'] = "ref002";
        # $post_data['value_c'] = "ref003";
        # $post_data['value_d'] = "ref004";

        $sslc = SSLCommerz::makePayment($post_data, 'hosted');

        # You can also use the embedded form:
        # $sslc = SSLCommerz::makePayment($post_data, 'embeded');
    }

    public function paymentSuccess(Request $request)
    {
        # Here you will receive all the information about the payment after a successful transaction.
        # Verify the transaction id and status.
        dd($request->all());
        // Update your database, send confirmation email, etc.
    }

    public function paymentFail(Request $request)
    {
        # Here you will receive all the information about the payment if the transaction was failed.
        # Check the error reason and update your database accordingly.
        dd($request->all());
        // Update your database, log the failure, etc.
    }

    public function paymentCancel(Request $request)
    {
        # Here you will receive all the information about the payment if the transaction was cancelled.
        # Update your database accordingly.
        dd($request->all());
        // Update your database, log the cancellation, etc.
    }

    public function ipn(Request $request)
    {
        # Receive IPN data here. At the end of this process, you have to send a GET request
        # to sslcommerz to verify the transaction.
        # Example: https://sandbox.sslcommerz.com/validator/api/merchantTransIDvalidationAPI.php?
        # val_id=your_val_id&store_id=your_store_id&store_passwd=your_store_passwd&v=1&format=json

        dd($request->all());
        // Process the IPN data, verify the transaction with SSLCommerz, update your database.
    }
}