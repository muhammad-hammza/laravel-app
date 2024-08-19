<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        $user = auth()->user();

        // Step 1: Get the token
        $tokenResponse = Http::asForm()->post('https://fib.dev.fib.iq/auth/realms/fib-online-shop/protocol/openid-connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => 'hazhar',
            'client_secret' => 'b8690e60-45b9-43d7-b475-5ef06d30da9c',
        ]);

        $token = $tokenResponse->json()['access_token'];

        // Step 2: Create the payment with the given structure
        $paymentResponse = Http::withToken($token)->post('https://fib.dev.fib.iq/protected/v1/payments', [
            'monetaryValue' => [
                'amount' => $request->amount, // Assume the amount is passed in the request
                'currency' => 'IQD', // Assuming the currency is always IQD
            ],
           'statusCallbackUrl' => route('payment.callback'),  // You can pass this URL in the request
            'description' => 'Pay with FIB',
            'expiresIn' => 'PT12H', // 12 hours expiration
            'refundableFor' => $request->refundableFor, // You can pass this in the request, if applicable
        ]);

        $paymentData = $paymentResponse->json();
        $request->validate([
            'plan_type' => 'required|string|in:free,monthly,yearly',
        ]);
        // Step 3: Save the order in the database
        $order = Order::create([
            'user_id' => $user->id,
            'payment_id' => $paymentData['paymentId'],
            'qr_code' => $paymentData['qrCode'],
            'personal_app_link' => $paymentData['personalAppLink'],
            'business_app_link' => $paymentData['businessAppLink'],
            'plan_type' => $request->plan_type,

            'status' => 'pending',
        ]);

        return response()->json([
          'token' => $token,
          'paymentData' => $paymentData
      ]);    }




    public function checkPaymentStatus($paymentId , Request $request)
    {
        $tokenResponse = Http::asForm()->post('https://fib.dev.fib.iq/auth/realms/fib-online-shop/protocol/openid-connect/token', [
            'grant_type' => 'client_credentials',
            'client_id' => 'hazhar',
            'client_secret' => 'b8690e60-45b9-43d7-b475-5ef06d30da9c',
        ]);

       // Check if token response is successful
       if ($tokenResponse->failed()) {
          return response()->json(['error' => 'Failed to get token'], 500);
      }
  
      $tokenData = $tokenResponse->json();
      if (!isset($tokenData['access_token'])) {
          return response()->json(['error' => 'Access token not found in response'], 500);
      }
  
      $token = $tokenData['access_token'];
  
      $statusResponse = Http::withToken($token)->get("https://fib.dev.fib.iq/protected/v1/payments/{$paymentId}/status");
  
      // Check if status response is successful
      if ($statusResponse->failed()) {
          return response()->json(['error' => 'Failed to get payment status'], 500);
      }
  
      $statusData = $statusResponse->json();
  
      // Check if status data contains the expected 'status' key
      if (!isset($statusData['status'])) {
          return response()->json(['error' => 'Payment status not found in response'], 500);
      }
  
      // Update order status
      $order = Order::where('payment_id', $paymentId)->first();

      if ($order) {
          // Update the status of the found order
          $order->update(['status' => $statusData['status']]);
      } else {
          // Return an error if the order was not found
          return response()->json(['error' => 'Order not found'], 404);
      }
    

      if ($statusData['status'] === 'PAID') {
        // Find the user associated with the order
        $user = User::find($order->user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Determine the new subscription end date based on the plan type
        $planType = $order->plan_type; // Assuming you store the plan type in the order
        $newEndDate = null;

        switch ($planType) {
            case 'free':
                $newEndDate = now()->addMonths(3);
                break;
            case 'monthly':
                $newEndDate = now()->addMonth();
                break;
            case 'yearly':
                $newEndDate = now()->addYear();
                break;
        }
    

        // Debugging: Log the user's data before the update
      

        // Update the user's subscription details in the users table
        $updated =  User::find($order->user_id);
        $updated->plan_type = $planType;
        $updated->subscription_end_date = $newEndDate;
        $updated->save();

    

        // Check if the update was successful
        if ($updated) {
            return response()->json(['message' => 'Subscription updated successfully', 'status' => $statusData['status']]);
        } else {
            return response()->json(['error' => 'Failed to update subscription'], 500);
        }
    } else {
        // If the payment is UNPAID, return a message indicating that
        return response()->json(['message' => 'Payment was not successful, subscription not updated', 'status' => $statusData['status']]);
    }
}

// bo garandnaway para
public function refundPayment($paymentId, Request $request)
{
    $tokenResponse = Http::asForm()->post('https://fib.dev.fib.iq/auth/realms/fib-online-shop/protocol/openid-connect/token', [
        'grant_type' => 'client_credentials',
        'client_id' => 'hazhar',
        'client_secret' => 'b8690e60-45b9-43d7-b475-5ef06d30da9c',
    ]);

   // Check if token response is successful
   if ($tokenResponse->failed()) {
      return response()->json(['error' => 'Failed to get token'], 500);
  }

  $tokenData = $tokenResponse->json();
  if (!isset($tokenData['access_token'])) {
      return response()->json(['error' => 'Access token not found in response'], 500);
  }

  $token = $tokenData['access_token'];
    // Make the refund request
    $refundResponse = Http::withToken($token)->post("https://fib.dev.fib.iq/protected/v1/payments/$paymentId/refund");

    if ($refundResponse->failed()) {
        return response()->json(['error' => 'Failed to process refund'], 500);
    }

    $refundData = $refundResponse->json();

    // Update the order status to 'REFUNDED'
    $order = Order::where('payment_id', $paymentId)->first();

    if ($order) {
        $order->update(['status' => 'REFUNDED']);
    } else {
        return response()->json(['error' => 'Order not found'], 404);
    }

    // Find the user associated with the order
    $user = User::find($order->user_id);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Reset the user's plan type and subscription end date
    $user->plan_type = null; // Assuming 'free' is the default plan
    $user->subscription_end_date = null;
    $user->save();

    return response()->json(['message' => 'Payment refunded and subscription reset successfully', 'refundData' => $refundData]);
}

// bo front aw routanay pewestyan ba payment haya
public function checkSubscriptionStatus(Request $request)
{
    $user = $request->user();

    // Assuming 'plan_type' and 'subscription_end_date' are in the 'users' table
    $subscriptionStatus = [
        'plan_type' => $user->plan_type,
        'subscription_end_date' => $user->subscription_end_date,
        'is_active' => $user->subscription_end_date >= now()
    ];

    return response()->json($subscriptionStatus);
}
// drust krdny api bas bo free payment bo away peweste ba card nabe 
public function freePlan(Request $request)
{

    
    $user = $request->user();

    if ($user->free_plan_used) {
     
        return response()->json([
            'message' => 'You have already used the free plan. Please consider upgrading to a premium plan.'
        ], 403);
    }
    else{
        $user->plan_type = 'free';
        $user->subscription_end_date = now()->addMonths(3);
        $user->free_plan_used = true;// ka user yak jar free pal e bakar hena yaksar abe ba true bo  away jar deka natwani bakare bhenetawa ba free
        $user->save();
    }
   
 
      
      return response([

"payment expire" =>$user->subscription_end_date

      ]);
}
public function handlePaymentCallback(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'id' => 'required|string',
            'status' => 'required|string',
        ]);

        // Retrieve the order based on the payment ID
        $order = Order::where('payment_id', $request->id)->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Update the order status based on the payment status
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Payment status updated successfully'], 200);
    }

}