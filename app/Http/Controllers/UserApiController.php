<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExamResource;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Quote;
use App\Models\SubmittedTest;
use App\Models\Test;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Auth;
use Str;
use Razorpay\Api\Api;
use Log;
use Razorpay\Api\Errors\SignatureVerificationError;
use Illuminate\Support\Facades\Mail;

class UserApiController extends Controller
{
    public function login(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6|max:244',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'VALIDATION_ERROR',
                    'message' => $validator->errors(),
                ]);
            }



            if (User::where('email', $request->email)->exists()) {


                $user = User::where('email', $request->email)->first();
                if ($user->password == null) {
                    return response(['message' => 'GOOGLE_LOGIN'], 422);
                }
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('auth_token')->accessToken;
                    // User::where('email', $request->email)->update([
                    //     'expiry_date' => Carbon::parse($token->token->expires_at)->format('Y-m-d'),
                    // ]);
                    $data = [
                        'token' => $token,
                        // 'expiry_date' =>  Carbon::parse($token->token->expires_at)->format('Y-m-d H:i:s'),
                    ];
                    return response(['user' => $user, 'token' => $data, 'message' => 'SUCCESS'], 200);
                } else {
                    return response(['message' => 'INVALID_CREDENTIALS'], 422);
                }
            } else {
                return response(['message' => 'NO_USER'], 422);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ])->setStatusCode(500);
        }
    }


    public function googleLogin(Request $request)
    {
        try {
            // $data = $request->all();
            // return response(['data' => $d],422);
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'VALIDATION_ERROR',
                    'message' => $validator->errors(),
                ])->setStatusCode(422);
            }

            if (User::where('email', $request->email)->exists()) {
                $user = User::where('email', $request->email)->first();
                if ($user->password != null) {
                    return response(['message' => 'NORMAL_LOGIN'], 422);
                }
                // if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('auth_token')->accessToken;
                // User::where('email', $request->email)->update([
                //     'expiry_date' => Carbon::parse($token->token->expires_at)->format('Y-m-d'),
                // ]);
                $data = [
                    'token' => $token,
                    // 'expiry_date' =>  Carbon::parse($token->token->expires_at)->format('Y-m-d H:i:s'),
                ];
                return response(['user' => $user, 'token' => $data, 'message' => 'SUCCESS'], 200);
                // } else {
                //     return response(['message' => 'INVALID_CREDENTIALS'], 422);
                // }
            } else {
                $user = User::create([
                    'email' => $request->email,
                    'name' => $request->name,
                    'user_type' => 3,
                    'status' => 1,
                ]);

                $token = $user->createToken('auth_token')->accessToken;
                // User::where('email', $request->email)->update([
                //     'expiry_date' => Carbon::parse($token->token->expires_at)->format('Y-m-d'),
                // ]);
                $data = [
                    'token' => $token,
                    // 'expiry_date' =>  Carbon::parse($token->token->expires_at)->format('Y-m-d H:i:s'),
                ];
                return response(['user' => $user, 'token' => $data, 'message' => 'SUCCESS'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ])->setStatusCode(500);
        }
    }

    public function profile()
    {
        $user = User::where('id', auth('api')->user()->id)->first();
        return response(['user' => $user, 'message' => 'SUCCESS'], 200);
    }

    public function profileUpdate(Request $request)
    {
        try {
            $id = auth('api')->user()->id;
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3|max:244',
                'phone' => 'required|digits_between:6,15|integer',
                'address_1' => 'required|min:3',
                'address_2' => 'nullable',
                'state' => 'required',
                'city' => 'required',
                'landmark' => 'nullable',
                'pincode' => 'required|integer|digits_between:6,7',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'VALIDATION_ERROR',
                    'message' => $validator->errors(),
                ])->setStatusCode(422);
            }

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email,' . $id,
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'MAIL_ERROR',
                    'message' => $validator->errors(),
                ])->setStatusCode(422);
            }

            User::where('id', auth('api')->user()->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'city' => $request->city,
                'state' => $request->state,
                'landmark' => $request->landmark,
                'pincode' => $request->pincode,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'success'
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ])->setStatusCode(500);
        }
    }

    public function logOut(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'name' => 'required|min:3|max:244',
                'password' => 'required|min:6|max:244',
                'confirmPassword' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'VALIDATION_ERROR',
                    'message' => $validator->errors(),
                ])->setStatusCode(422);
            }

            if (User::where('email', $request->email)->exists()) {
                return response(['message' => 'EMAIL_EXISTS'], 422);
            } else {
                $user = User::create([
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'name' => $request->name,
                    'status' => 1,
                    'user_type' => 3
                ]);
                // $token = $user->createToken('auth_token');
                $token = $user->createToken('auth_token')->accessToken;

                // User::where('email', $request->email)->update([
                //     'expiry_date' => Carbon::parse($token->token->expires_at)->format('Y-m-d'),
                // ]);
                $data = [
                    'token' => $token,
                    // 'expiry_date' =>  Carbon::parse($token->token->expires_at)->format('Y-m-d H:i:s'),
                ];
                return response(['user' => $user, 'token' => $data, 'message' => 'SUCCESS'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ])->setStatusCode(500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [

                'password' => 'required|min:6|max:244',
                'confirmPassword' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'VALIDATION_ERROR',
                    'message' => $validator->errors(),
                ])->setStatusCode(422);
            }

            User::where('id', auth('api')->user()->id)->update([
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Password Changed Successfully'
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ])->setStatusCode(422);
        }
    }

    public function paymentStatus(Request $request)
    {
        try {
            $course_id = Test::where('id', $request->courseId)->pluck('course_id')->first();
            $order = Order::where([['user_id', auth('api')->user()->id], ['course_id', $course_id], ['status', 1]])->first();
            if ($order == null) {
                $paymentStatus = 0;
            } elseif ($order != null) {
                $paymentStatus = 1;
            }

            return response()->json([
                'status' => 200,
                'payment' => $paymentStatus,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ])->setStatusCode(500);
        }
    }

    public function orderInitiate(Request $request)
    {

        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            Log::info(env('RAZORPAY_KEY') . 'disl' . env('RAZORPAY_SECRET'));
            // Log::info();
            Log::info("message");
            if ($request->examId == 0) {
                $course_id = Test::where('id', $request->courseId)->pluck('course_id')->first();
            } elseif ($request->examId == 1) {
                $course_id = $request->courseId;
            }
            $courseData = Course::where('id', $course_id)->first();

            $razorpayOrder = $api->order->create(array('receipt' => Str::random(20), 'amount' => $courseData->price * 100, 'currency' => 'INR'));

            Order::create([
                'order_id' => $razorpayOrder['id'],
                'user_id' => auth('api')->user()->id,
                'status' => 0,
                'amount' => $razorpayOrder['amount'] / 100,
                'course_id' => $course_id,
                'payment_type' => 1,
                'exam_id' => $courseData->exam_id,
            ]);

            return response()->json([
                'order_id' => $razorpayOrder['id'],
                'amount' => $razorpayOrder['amount'],
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ])->setStatusCode(500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'orderCreationId' => 'required',
                'razorpayPaymentId' => 'required',
                'razorpayOrderId' => 'required',
                'razorpaySignature' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'VALIDATION_ERROR',
                    'message' => $validator->errors(),
                ])->setStatusCode(422);
            }

            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            // $verify =$api->payment->fetch($request->orderCreationId);

            // if ($verify->id == $request->razorpayPaymentId) {
            //     Order::where('order_id',$request->orderCreationId)->update([
            //         'status' => 1,
            //     ]);
            // }else{
            //     return response()->json([
            //         'error' => 'An error occured',
            //         'message' => 'Payment Tampered',
            //     ])->setStatusCode(422);
            // }
            $attributes = array(
                'razorpay_order_id' => $request->orderCreationId,
                'razorpay_payment_id' => $request->razorpayPaymentId,
                'razorpay_signature' => $request->razorpaySignature
            );

            try {
                $api->utility->verifyPaymentSignature($attributes);
                // $paymentData =$api->payment->fetch($$request->razorpayPaymentId);
                // return response()->json([
                //     'data' => $paymentData ,
                // ])->setStatusCode(500);
                Order::where('order_id', $request->orderCreationId)->update([
                    'status' => 1,
                    'razorpay_signature' => $request->razorpaySignature,
                    'razorpay_payment_id' => $request->razorpayPaymentId,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'SUCCESS'
                ]);
            } catch (SignatureVerificationError  $th) {
                return response()->json([
                    'error' => 'An error occured',
                    'message' => $th->getMessage(),
                ])->setStatusCode(422);
            }



            // Order::create([
            //     'razorpay_payment_id' => $request->razorpayPaymentId,
            //     'order_id' => $request->razorpayOrderId,
            //     'razorpay_order_id' => $request->razorpayOrderId,
            //     'razorpay_signature' => $request->razorpaySignature,
            // ]);

        } catch (\Throwable $th) {

            return response()->json([
                'error' => 'An error occured',
                'message' => $th->getMessage(),
            ])->setStatusCode(422);
        }
    }

    public function notifications()
    {
        try {
            $datas = Notification::where([['user_id', auth('api')->user()->id], ['status', 1]])->get();
            return response()->json([
                'data' => $datas,
                'status' => 200,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'An error occured',
                'message' => $th->getMessage(),
            ])->setStatusCode(500);
        }
    }

    public function clearNotifications()
    {
        try {
            $datas = Notification::where([['user_id', auth('api')->user()->id], ['status', 1]])->update([
                'status'=> 0,
            ]);
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'An error occured',
                'message' => $th->getMessage(),
            ])->setStatusCode(500);
        }
    }

    public function getCourse()
    {
        $purchaseCourse = Order::where([['user_id', auth('api')->user()->id], ['status', 1]])->pluck('course_id')->toArray();
        $purchaseExam = Order::where([['user_id', auth('api')->user()->id], ['status', 1]])->pluck('exam_id')->toArray();

        $datas = Exam::whereIn('id', $purchaseExam)->get();
        foreach ($datas as $key => $value) {
            foreach ($value->courses as $course) {
                if (in_array($course->id, $purchaseCourse)) {
                    $value['course_purchased_url'] = $course->name;
                }
            }
            $value['course_purchase'] = 1;
        }

        return ExamResource::collection($datas);
    }

    public function getReports()
    {
        return SubmittedTest::where('user_id', auth('api')->user()->id)->with('test', 'test.course.exam')->paginate(6);
    }

    public function analytics()
    {
        try {
            $quotes = Quote::inRandomOrder()->first();
            $purchaseCourse = Order::select('id', 'user_id', 'course_id', 'exam_id')->where([['user_id', auth('api')->user()->id], ['status', 1]])->with('exams', 'courses:id,slug,name', 'exams:id,slug,name')->get();
            $evaluatedReports = SubmittedTest::where('user_id', auth('api')->user()->id)->with('test', 'test.course.exam')->get();
            return response()->json([
                'quote' => $quotes,
                'purchase_data' => $purchaseCourse,
                'evaluated_reports' => $evaluatedReports
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => $th->getMessage(),
            ])->setStatusCode(500);
        }
    }

    public function motivationQuotes(Request $request)
    {
        try {
            $datas = $request->toArray();
            foreach ($datas as $data) {
                Quote::create([
                    'quote' => $data['quote'],
                ]);
            }
            return response()->json([
                'message' => 'success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'error',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function checkMail(Request $request)
    {
        try {
            if (User::where('email', $request->email)->exists()) {
                $user = User::where('email', $request->email)->first();

                if ($user->password == null) {
                    return response()->json([
                        'message' => 'GOOGLE_LOGIN'
                    ])->setStatusCode(422);
                }
                $otp = rand(100000, 999999);
                User::where('email', $request->email)->update([
                    'otp' => $otp,
                ]);
                $details = [
                    'otp' => $otp,
                ];
                // \Mail::to($request->email)->send(new \App\Mail\PasswordRecoveryMail($details));

                return response()->json([
                    'message' => 'success',
                ])->setStatusCode(200);
            } else {
                return response()->json([
                    'message' => 'NO_USER',
                ])->setStatusCode(422);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function checkOtp(Request $request)
    {
        try {
            if (User::where('email', $request->email)->exists()) {

                $user = User::where('email', $request->email)->first();



                if ($user->otp == $request->otp) {
                    User::where('email',$request->email)->update([
                        'password' => bcrypt($request->password),
                    ]);
                    return response()->json([
                        'message' => 'PASSWORD_CHANGED'
                    ])->setStatusCode(200);
                } else {
                    return response()->json([
                        'message' => 'OTP_ERROR'
                    ])->setStatusCode(422);
                }
            } else {
                return response()->json([
                    'message' => 'MAIL_ERROR'
                ])->setStatusCode(422);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'SERVER_ERROR',
                'data' => $th->getMessage(),
            ])->setStatusCode(500);
        }
    }
}
