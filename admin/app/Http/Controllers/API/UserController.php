<?php

namespace App\Http\Controllers\API;
use App\Models\Business;
use App\Models\Download;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use App\Helpers\Whatsapp;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Personal;
use Mail;
use Carbon\Carbon;
class UserController extends Controller
{
    public function registration(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "mobileno" => "required|digits:10",
        ]);
        if ($validator->fails()) {
            return response(["errors" => $validator->errors()->all()], 422);
        }
        $mobileno = $request->mobileno;
        $user = User::where("mobileno", $mobileno)->first();
        if ($user) 
        {
            $otp = rand(1000, 9999);
            $otp_expires_time = Carbon::now("Asia/Kolkata")->addSeconds(120);
            if($mobileno == '1234567890')
            {
                $response = [
                    "success" => true,
                    "message" => "OTP sent to your Mobile Number",
                    "data" => [
                        "name" => $user->name,
                        "email" => $user->email,
                        "mobileno" => $user->mobileno,
                        "user_id" => $user->id,
                    ],
                    "statusCode" => 200,
                ];
                return response()->json($response, 200);   
            }
            $data = "To Verify Your Mail Your otp is:" . $otp;
            $response = Whatsapp::sendotp($mobileno, $otp);
            if ($response != false) 
            {
                User::where("mobileno", $mobileno)->update([
                    "otp" => $otp,
                    "email_verified_at" => $otp_expires_time,
                ]);
                $response = 
                [
                    "success" => true,
                    "message" => "OTP sent to your Mobile Number",
                    "data" => [
                        "name" => $user->name,
                        "email" => $user->email,
                        "mobileno" => $user->mobileno,
                        "user_id" => $user->id,
                    ],
                    "statusCode" => 200,
                ];
                return response()->json($response, 200);
            }
            else 
            {
                return response()->json([
                    "success" => false,
                    "message" => "Failed to send message.",
                    "statusCode" => 400,
                ]);
            }
        }
        $otp = rand(1000, 9999);
        $otp_expires_time = Carbon::now("Asia/Kolkata")->addMinutes(2);
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "mobileno" => $request->mobileno,
            "otp" => $otp,
            // "user_type" =>1,
            "otp_expires_at" => $otp_expires_time,
        ]);
        if ($user) 
        {
            if($mobileno == '1234567890'){
                
                $response = [
                    "success" => true,
                    "message" => "OTP sent to your Mobile Number",
                    "data" => [
                        "name" => $user->name,
                        "email" => $user->email,
                        "mobileno" => $user->mobileno,
                        "user_id" => $user->id,
                    ],
                    "statusCode" => 200,
                ];
                return response()->json($response, 200);   
            }
            $response = Whatsapp::sendotp($mobileno, $otp);
            if ($response != false) 
            {
                $response = [
                    "success" => true,
                    "message" =>
                        "User added successfully and OTP sent to your Mobile number",
                    "data" => [
                        "name" => $user->name,
                        "email" => $user->email,
                        "mobileno" => $user->mobileno,
                        "user_id" => $user->id,
                    ],
                    "statusCode" => 200,
                ];
                return response()->json($response, 200);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "Failed to send message.",
                    "statusCode" => 400,
                ]);
            }
        }


    }
    public function verifyemail(Request $request)
    {
        $now = Carbon::now("Asia/Kolkata");
        $validator = Validator::make($request->all(), [
            "mobileno" => "required|string|max:255",
            "otp" => "required",
        ]);
        if ($validator->fails()) {
            return response(["errors" => $validator->errors()->all()], 422);
        }
        $user = User::where("mobileno", $request->mobileno)->first();

        if (!$user) {
            return ApiResponse::error("Invalid credentials");
        }
        if ($request->mobileno == '1234567890' && $request->otp == '1111') {
            $user->email_verified_at = $now;
            $user->save();
            return ApiResponse::success($user, "Email verified successfully");
        }

        $otpExpiration = Carbon::parse($user->updated_at)->addMinutes(2);
        if ($now > $otpExpiration) {
            // $user->delete();
            return ApiResponse::error("OTP expired");
        }

 

        if ($user->otp !== $request->otp) {
            // $newOtp = rand(100000, 999999);
            // $user->otp = $newOtp;
            // $user->save();
            return ApiResponse::error("Invalid OTP");
        }

        $user->email_verified_at = $now;
        $user->save();
        return ApiResponse::success($user, "Email verified successfully");
    }
    public function verifymobile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "mobileno" => "required|max:255",
        ]);
        if ($validator->fails()) {
            return response(["errors" => $validator->errors()->all()], 422);
        }

        $mobileno = $request->mobileno;
        $user = User::where("mobileno", $mobileno)->first();
        if (!$user) {
            return ApiResponse::error("User not found");
        }


        $response = [
            "success" => true,
            "message" => "User Found",
            "data" => [
                "name" => $user->name,
                "email" => $user->email,
                "mobileno" => $user->mobileno,
                "user_id" => $user->id,
            ],
            "statusCode" => 200,
        ];
        return response()->json($response, 200);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "mobileno" => "required|max:255",
        ]);
        if ($validator->fails()) {
            return response(["errors" => $validator->errors()->all()], 422);
        }

        $mobileno = $request->mobileno;
        $user = User::where("mobileno", $mobileno)->first();
        if (!$user) {
            return ApiResponse::error("User not found");
        }
        if ($user) {
            $otp = rand(1000, 9999);
            $otp_expires_time = Carbon::now("Asia/Kolkata")->addSeconds(120);
            $data = "To Verify Your Mail Your otp is:" . $otp;

            if($mobileno == '1234567890'){
                $response = [
                    "success" => true,
                    "message" => "OTP sent to your Mobile Number",
                    "data" => [
                        "name" => $user->name,
                        "email" => $user->email,
                        "mobileno" => $user->mobileno,
                        "user_id" => $user->id,
                    ],
                    "statusCode" => 200,
                ];
                return response()->json($response, 200);   
            }
            $response = Whatsapp::sendotp($user->mobileno, $otp);
            if ($response->successful()) {
                User::where("mobileno", $mobileno)->update([
                    "otp" => $otp,
                    "email_verified_at" => $otp_expires_time,
                ]);

                $response = [
                    "success" => true,
                    "message" => "OTP sent to your Mobile Number",
                    "data" => [
                        "name" => $user->name,
                        "email" => $user->email,
                        "mobileno" => $user->mobileno,
                        "user_id" => $user->id,
                    ],
                    "statusCode" => 200,
                ];
                return response()->json($response, 200);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "Failed to send message.",
                    "statusCode" => 400,
                ]);
            }
        }
    }
    public function userdata(Request $request)
    {
        $user_id = $request->input("user_id");

        if (!$user_id) {
            return response()->json(["error" => "No user_id provided"], 400);
        }

        $user = User::find($user_id);
        if (!$user) {
            return response()->json(
                ["error" => "No user found for the given user_id"],
                404
            );
        }

        $personal = Personal::where("user_id", $user_id)->first();

        $business = Business::where("user_id", $user_id)
            ->orderBy("id", "desc")
            ->get();

        $responseData = [
            "user_details" => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "mobileno" => $user->mobileno,
                "user_type" => $user->user_type,
            ],

            "business" => $business->isEmpty()
                ? []
                : $business
                    ->map(function ($item) {
                        return [
                            "business_id" => $item->id,
                            "logo_image" => url("images/" . $item->logo_image),
                            "business_name" => $item->business_name,
                            "mobile_no" => $item->mobile_no,
                            "business_email" => $item->email,
                            "website" => $item->website,
                            "pincode" => $item->pincode,
                            "address" => $item->address,
                        ];
                    })
                    ->toArray(),

            "personal_details" => $personal
                ? [
                    "personal_details_id" => $personal->id,
                    "user_id" => $personal->user_id,
                    "logo_image" => url("images/" . $personal->logo),
                    "name" => $personal->name,
                    "email_id" => $personal->email_id,
                    "mobile_no" => $personal->mobile_number,
                ]
                : null,
        ];

        return response()->json(["data" => $responseData]);
    }
    public function deletealluserdata(Request $request)
    {
        $downloadid = $request->id;

        $downloadsDeleted = Download::where("user_id", $downloadid)->delete();
        $downloadsDeleted = Business::where("user_id", $downloadid)->delete();

        $userDeleted = User::where("id", $downloadid)->delete();

        if ($downloadsDeleted) {
            $extimages = Download::where("user_id", $downloadid)->get();
            foreach ($extimages as $extimage) {
                $filePath = public_path("images/" . $extimage->download_image);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $response = [
                "downloads_deleted" => $downloadsDeleted,
                "user_deleted" => $userDeleted,
                "download_images" => $extimages
                    ->pluck("download_image")
                    ->toArray(),
            ];

            return APIResponse::success($response, "Data deleted successfully");
        } else {
            return APIResponse::error(null, "Data not deleted successfully");
        }
    }
    public function updateuser(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::find($user_id);

        if ($user != null) {
            if ($request->has("name")) {
                $user->name = $request->name;
            }

            if ($request->has("email")) {
                $user->email = $request->email;
            }

            if ($request->has("user_type")) {
                $user->user_type = $request->user_type;
            }

            $user->save();

            return ApiResponse::success($user, "User updated successfully");
        }

        return ApiResponse::error("no user found");
    }
    public function personaldetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "logo" => "required",
            "name" => "required|string",
            "mobile_number" => "required|string",
            "email_id" => "required|string",

            "user_id" => "required|exists:users,id",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $unique = uniqid();
        $filename = time() . "." . $unique . "." . $request->logo->extension();
        $request->logo->move(public_path("images"), $filename);
        $requestData = $request->all();
        $bussiness = [
            "logo" => $filename,
            "name" => $requestData["name"],
            "mobile_number" => $requestData["mobile_number"],
            "email_id" => $requestData["email_id"],

            "user_id" => $requestData["user_id"],
        ];
        $user = User::find($request->user_id);
        $insertdata = Personal::create($bussiness);

         

        if ($insertdata) {
            $user->user_type = 0;
            $user->save();
            return ApiResponse::success(
                $insertdata,
                "Registration successfull"
            );
        } else {
            return ApiResponse::error("data", "errro");
        }
    }
    public function updatepuersonaldetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "personal_details_id" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = Personal::find($request->personal_details_id);

        if (!$data) {
            return ApiResponse::error("Personal details not found");
        }

        if ($request->hasFile("logo")) {
            if ($data->logo) {
                $image_path = public_path("images") . "/" . $data->logo;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            $unique = uniqid();
            $filename =
                time() . "." . $unique . "." . $request->logo->extension();
            $request->logo->move(public_path("images"), $filename);
            $data->logo = $filename;
        }
        if ($request->has("name")) {
            $data->name = $request->name;
        }
        if ($request->has("mobile_number")) {
            $data->mobile_number = $request->mobile_number;
        }
        if ($request->has("user_id")) {
            $data->user_id = $request->user_id;
        }
        if ($request->has("email_id")) {
            $data->email_id = $request->email_id;
        }

        $data->save();

        $data->logo = url("images/" . $data->logo);

        return ApiResponse::success(
            $data,
            "Personal Details updated successfully"
        );
    }
}
