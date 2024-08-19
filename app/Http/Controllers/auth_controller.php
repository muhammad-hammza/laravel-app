<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use PhpParser\Builder\Use_;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Mail\PasswordResetMail;
use App\Mail\EmailVerificationMail;
use App\Models\EmailVerification;
use App\jobs\SendEmailVerificationJob;
use App\Jobs\SendPasswordResetEmail;

class auth_controller extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validate user input including password confirmation
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    function ($attribute, $value, $fail) {
                        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/', $value)) {
                            return $fail('Password must be at least 8 characters and include at least one uppercase letter, one lowercase letter, and one digit.');
                        }
                    },
                ],
            ], [
                'name.required' => 'name_required',
                'email.unique' => 'email_unique',
                'email.required' => 'email_required',
            ]);
    
            // Sanitize inputs to prevent XSS (if needed)
            $cleanName = strip_tags($request->input('name'));
            $cleanEmail = filter_var($request->input('email'), FILTER_SANITIZE_EMAIL);
            $cleanPassword = htmlspecialchars($request->input('password'));
    
            // Create a new user
            $user = User::create([
                'name' => $cleanName,
                'email' => $cleanEmail,
                'password' => Hash::make($cleanPassword),
            ]);
    
            // Generate email verification token
            $verificationToken =  random_int(1000, 9999);// Adjust length as needed
    
            // Store the token in the database
            DB::table('email_verifications')->updateOrInsert(
                ['email' => $cleanEmail],
                ['token' => $verificationToken, 'created_at' => now()]
            );
    
            // Check if a verification email has been sent before
            if ($user->email_verified_at === null) {
                // Dispatch the job to send verification email
                SendEmailVerificationJob::dispatch($cleanEmail, $verificationToken);
            }
    
            // Return success message
            return response()->json([
                'message' => 'Registration successful. Please check your email for verification.',
            ]);
    
        } catch (ValidationException $e) {
            // Return validation errors
            return response()->json(['errors' => $e->errors()], 422);
    
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => 'An error occurred while processing your request. Please try again later.'], 500);
        }
    }
    

public function resendVerificationEmail(Request $request)
{
    try {
        // Validate the input
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'email_required',
            'email.exists' => 'email_not_found',
        ]);

        // Sanitize email input
        $cleanEmail = filter_var($request->input('email'), FILTER_SANITIZE_EMAIL);

        // Find the user
        $user = User::where('email', $cleanEmail)->first();

        // Check if the email is already verified
        if ($user->email_verified_at !== null) {
            return response()->json(['message' => 'Email is already verified.'], 400);
        }

        // Generate a new email verification token
        $verificationToken =  random_int(1000, 9999);// Adjust length as needed

        // Store the token in the database
        DB::table('email_verifications')->updateOrInsert(
            ['email' => $cleanEmail],
            ['token' => $verificationToken, 'created_at' => now()]
        );

        // Dispatch the job to send verification email
        SendEmailVerificationJob::dispatch($cleanEmail, $verificationToken);

        // Return success message
        return response()->json([
            'message' => 'Verification email resent. Please check your email.',
        ]);

    } catch (ValidationException $e) {
        // Return validation errors
        return response()->json(['errors' => $e->errors()], 422);

    } catch (\Exception $e) {
        // Handle other exceptions
        return response()->json(['error' => 'An error occurred while processing your request. Please try again later.'], 500);
    }
}



    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
        ]);

        $emailVerification = EmailVerification::where('email', $request->email)
                                ->where('token', $request->token)
                                ->first();

        if (!$emailVerification) {
            return response()->json(['message' => 'Invalid token or email.'], 422);
        }

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Mark the email as verified
        $user->email_verified_at = now(); // Laravel's built-in timestamp for email verification
        $user->save();

        // Delete the email verification record
        EmailVerification::where('email', $request->email)->delete();

        return response()->json(['message' => 'Email has been verified.']);
    }
  


  //login api
  public function login(Request $request)
  {
      try {
          // Validate user input with custom error messages
         // Validate user input with custom error messages
         $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    // Get the user
                    $user = User::where('email', $request->email)->first();

                    // Check if the user exists and if the password is correct
                    if (!$user || !Hash::check($value, $user->password)) {
                        return $fail('Incorrect password.'); // Custom message for incorrect password
                    }
                },
            ],
        ], [
            'email.required' => 'Please provide your email address.',
            'email.email' => 'Please enter a valid email address for the email field.',
            'email.exists' => 'Email not found.',
        ]);
          // Check if the user exists
          $user = User::where('email', $request->email)->first();
  
          if (!$user) {
              return response(['message' => 'Email not found.'], Response::HTTP_UNAUTHORIZED);
          }
  
          // Attempt authentication
          if (Auth::attempt($request->only('email', 'password'))) {
              $user = Auth::user();
              // Create token with expiration
              $token = $user->createToken('token', ['*'], now()->addHours(24))->plainTextToken;
  
              // Create secure cookie
              return response([
                  'user' => $user,
                  'token' => $token,
              ])->cookie('jwt', $token, 1440, null, null, true, true); // 1440 minutes = 24 hours
          }
  
          // If authentication fails (incorrect password)
          return response(['message' => 'Invalid password.'], Response::HTTP_UNAUTHORIZED);
  
      } catch (ValidationException $e) {
          // Handle validation errors
          $errors = $e->errors();
          $errorMessages = [];
  
          // Check for email validation errors
          if (isset($errors['email'])) {
              $errorMessages['email'] = $errors['email'][0];
          }
  
          // Check for password validation errors
          if (isset($errors['password'])) {
              $errorMessages['password'] = $errors['password'][0];
          }
  
          // Return validation errors to the user
          return response(['errors' => $errorMessages], Response::HTTP_UNPROCESSABLE_ENTITY);
  
      } catch (\Exception $e) {
          // Handle other exceptions and return an appropriate response
          return response(['error' => 'An error occurred while processing your request. Please try again later.'], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
  }
  
  
  
//logout api
public function logout()
{
    try {
        $cookie = Cookie::forget('jwt');
        return response([
            'message' => 'Logout successful'
        ])->withCookie($cookie);
    } catch (\Exception $e) {
        // Handle other exceptions and return an appropriate response
        return response(['error' => 'An error occurred while processing your request. Please try again later.'], 500);
    }
}
//Send a password reset link to the user's email.
// public function forgotPassword(Request $request)
// {
//     try {
//         // Validate email for password reset
//           $request->validate([
//         'email' => 'required|email',
//         'password' => 'required|string',
//     ], [
//         'email.required' => 'Please provide your email address.',
//         'email.email' => 'Please enter a valid email address.',
//         'password.required' => 'Please provide your password.',
//     ]);

//         // Send password reset link
//         $status = Password::sendResetLink(
//             $request->only('email')
//         );
//         return $status === Password::RESET_LINK_SENT
//             ? response(['message' => 'Reset link sent to your email.'], 200)
//             : response(['message' => 'Unable to send reset link.'], 400);
//     } catch (\Exception $e) {
//         //return error message

//         Log::error('Forgot password error: ' . $e->getMessage());
//         return response(['error' => $e->getMessage()], 500);
//     }
// }




//  public function forgetPassword (Request $request){
// try{

// $user  = User::where('email',$request->email->get());
// if(count($user) > 0){
// $token = Str::random(40);
// $domain = URL::to('/');
// $url = $domain.'/reset-password?token='. $token;
// $data  ['url'] = $url;
// $data  ['email'] = $request->email;
// $data  ['title'] = 'Reset Password';
// $data  ['body'] = 'Please click the link below to reset your password';


// Mail::send('forgetPasswordMail',['data' => $data],function($message)use($data){
//     $message->to($data['email'])->subject($data['title']);

// });

// $dateTime = Carbon::now()->format('Y-m-d H:i:s');
// passwordReset::updateOrCreate(

// ['email' => $request->email,],
// [
//     'email' => $request->email,
//     'token' => $token,
//     'created_at' => $dateTime,
//     'updated_at' => $dateTime,
// ]
// );
// return response()->json(['success' => true , 'msg' => 'please cheak your email to resset your password']);
// }

// else{
//     return response()->json(['success' => false , 'msg' => 'User Not Found']);

// }
// }

// catch(\Exception $e){
//     return response()->json(['success' => false , 'msg' => $e->getMessage()]);

// }

//  }



public function sendResetCode(Request $request)
{
    $request->validate([
        'email' => [
            'required',
            'email',
            function ($attribute, $value, $fail) {
                if (!User::where('email', $value)->exists()) {
                    $fail('Email not found.');
                }
            } 
        ],
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'Email not found.'], 404);
    }

    // Generate a token
    $token = Password::createToken($user);

    // Store the reset code
    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $request->email],
        ['token' => $token, 'created_at' => now()]
    );

    // Generate reset link
    $resetLink = url("http://localhost:3000/Reset-Password/{$token}?email={$request->email}");

    // Dispatch the job to send email asynchronously
    SendPasswordResetEmail::dispatch($request->email, $resetLink);

    return response()->json(['message' => 'Reset link sent to your email.']);
}

public function reset(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'token' => 'required|string',
    ]);

    $passwordReset = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->where('token', $request->token)
        ->first();

    if (!$passwordReset) {
        return response()->json(['message' => 'Invalid token or email.'], 422);
    }

    return response()->json(['message' => 'Code verified.']);

}

public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'token' => 'required|string',
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            function ($attribute, $value, $fail) {
                if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/', $value)) {
                    return $fail('Password must be at least 8 characters and include at least one uppercase letter, one lowercase letter, and one digit.');
                }
            },
        ],    ]);

    $passwordReset = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->where('token', $request->token)
        ->first();

    if (!$passwordReset) {
        return response()->json(['message' => 'Invalid token or email.'], 422);
    }

    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json(['message' => 'User not found.'], 404);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    // Delete the reset token
    DB::table('password_reset_tokens')->where('email', $request->email)->delete();

    return response()->json(['message' => 'Password has been reset.']);
}




public function get_users(Request $request)
    {
        // Retrieve search query from the request
        $name = $request->input('name');


        // Query all freelancers
        $query = User::query();

        // If search query is provided, filter the results
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }
 
        
        // Get the page number from the request
        $page = $request->input('page', 1);

        // Paginate the results based on the search query
        $data = $query->paginate(10, ['*'], 'page', $page);

        // Return response with paginated data and total pages
        return response([
            "data" => $data,
            'total_pages' => $data->lastPage(), // Total number of pages
        ]);
    }
public  function  update_users (Request $request,$id){
    $update = User::find($id);
    $update->name = $request->name;
    $update->email = $request->email;
    $update->role = $request->role;
    $update->save();
        return response([
            'data' => $update

        ]);
}
public  function  delete_users ($id){
    $delete = User::find($id);
$delete->delete();
 return response([
 'message' => 'Deleted Successfully'
 ]);
}
}