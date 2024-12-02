<?php

namespace App\Http\Controllers\api;
use App\Models\Bussiness_category;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class BussinessController extends Controller
{
    public function bussiness_add(Request $request)
    {
       $data = [];
     if($request->has('id'))
        {
            $businessdata = Business::find($request->id);

            if($businessdata)
            {
                if ($request->hasFile("logo_image")) {
                    if ($businessdata->logo_image) {
                        $image_path =
                            public_path("images") . "/" . $businessdata->logo_image;
                        if (file_exists($image_path)) {
                            unlink($image_path);
                        }
                    }
        
                    $unique = uniqid();
                    $filename =
                        time() .
                        "." .
                        $unique .
                        "." .
                        $request->logo_image->extension();
                    $request->logo_image->move(public_path("images"), $filename);
                    $businessdata->logo_image = $filename;
                }
                if ($request->has("business_name")) {
                    $businessdata->business_name = $request->business_name;
                }
        
                if ($request->has("mobile_no")) {
                    $businessdata->mobile_no = $request->mobile_no;
                }
                if ($request->has("email")) {
                    $businessdata->email = $request->email;
                }
                if ($request->has("website")) {
                    $businessdata->website = $request->website;
                }
                if ($request->has("address")) {
                    $businessdata->address = $request->address;
                }
                if ($request->has("pincode")) {
                    $businessdata->pincode = $request->pincode;
                }
                if ($request->has("user_id")) {
                    $businessdata->user_id = $request->user_id;
                }
                if ($request->has("business_category_id")) {
                    $businessdata->business_category_id = $request->business_category_id;
                }
        
                if ($request->has("status")) {
                    $businessdata->business_category_id = $request->status;
                }
        

                $businessdata->save();

                $data = [
                    "id" => $businessdata->id,
                    "logo_image" => url("images/" . $businessdata->logo_image),
                    "business_name" => $businessdata->business_name,
                    "mobile_no" => $businessdata->mobile_no,
                    "email" => $businessdata->email,
                    "website" => $businessdata->website,
                    "address" => $businessdata->address,
                    "pincode" => $businessdata->pincode,
"user_id" => (int) $businessdata->user_id, 
                    "business_category_id" => (int)$businessdata->business_category_id,
                    "status" => $businessdata->status,
                ];


                return ApiResponse::success($data, "Business updated successfully");
        
            }

            return ApiResponse::error("Business not found", "error");

        }
        $validator = Validator::make($request->all(), 
        [
            "logo_image" => "required",
            "business_name" => "required|string",
            "business_category_id" => "required",
            "mobile_no" => "required|string",
            "email" => "required|string",
            "website" => "required|string",
            "address" => "required|string",
            "pincode" => "required|string",
            "user_id" => "required|exists:users,id",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $dataa = Business::where("user_id", $request->user_id)->first();
        $unique = uniqid();
        $filename =time() . "." . $unique . "." . $request->logo_image->extension();
        $request->logo_image->move(public_path("images"), $filename);
        $requestData = $request->all();
        $bussiness = [
            "logo_image" => $filename,
            "business_name" => $requestData["business_name"],
            "mobile_no" => $requestData["mobile_no"],
            "business_category_id" => $requestData["business_category_id"],
            "email" => $requestData["email"],
            "website" => $requestData["website"],
            "address" => $requestData["address"],
            "pincode" => $requestData["pincode"],
            "user_id" => $requestData["user_id"],
            "status" => 0,
        ];
        if (!$dataa) {
            $bussiness["status"] = 1;
        }
        $insertdata = Business::create($bussiness);
        if ($insertdata) {

            $data = [
                "id" => $insertdata->id,
                "logo_image" => url("images/" . $insertdata->logo_image),
                "business_name" => $insertdata->business_name,
                "mobile_no" => $insertdata->mobile_no,
                "email" => $insertdata->email,
                "website" => $insertdata->website,
                "address" => $insertdata->address,
                "pincode" => $insertdata->pincode,
"user_id" => (int) $insertdata->user_id, 
                "business_category_id" => (int)$insertdata->business_category_id,
                "status" => $insertdata->status,
            ];
            return ApiResponse::success(
                $data,
                "Registration successfull"
            );
        } else {
            return ApiResponse::error("data", "errro");
        }
    }
    public function getbussinessdata(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required",
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(null, $validator->errors()->first());
        }
        $data = [];
        $id = $request->bussiness_id;
        $club = Business::where("id", $id)->get();

        if ($club->isEmpty()) {
            return ApiResponse::error("No data found");
        }

        foreach ($club as $dataa) {
            $data[] = [
                "logo_image" => url("images/" . $dataa->logo_image),
                "business_name" => $dataa->business_name,
                "owner_name" => $dataa->owner_name,
                "mobile_no" => $dataa->mobile_no,
                "second_mobile_no" => $dataa->second_mobile_no,
                "email" => $dataa->email,
                "website" => $dataa->website,
                "address" => $dataa->address,
                "state" => $dataa->state,
                "user_id" => $dataa->user_id,
                "business_category_id" => $dataa->business_category_id,
                "status" => $dataa->status,
            ];
        }

        return ApiResponse::success(
            $data,
            "Business data displayed successfully"
        );
    }
    public function updateBusiness(Request $request)
    {
        $business = Business::find($request->id);
        if (!$business) {
            return ApiResponse::error("Business not found", "error");
        }
        if ($request->hasFile("logo_image")) {
            if ($business->logo_image) {
                $image_path =
                    public_path("images") . "/" . $business->logo_image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            $unique = uniqid();
            $filename =
                time() .
                "." .
                $unique .
                "." .
                $request->logo_image->extension();
            $request->logo_image->move(public_path("images"), $filename);
            $business->logo_image = $filename;
        }
        if ($request->has("business_name")) {
            $business->business_name = $request->business_name;
        }

        if ($request->has("mobile_no")) {
            $business->mobile_no = $request->mobile_no;
        }
        if ($request->has("email")) {
            $business->email = $request->email;
        }
        if ($request->has("website")) {
            $business->website = $request->website;
        }
        if ($request->has("address")) {
            $business->address = $request->address;
        }
        if ($request->has("pincode")) {
            $business->pincode = $request->pincode;
        }
        if ($request->has("user_id")) {
            $business->user_id = $request->user_id;
        }
        if ($request->has("business_category_id")) {
            $business->business_category_id = $request->business_category_id;
        }

        if ($request->has("status")) {
            $business->business_category_id = $request->status;
        }

        // Save the business details
        $business->save();

        return ApiResponse::success($business, "Business updated successfully");
    }
    public function show(Request $request)
    {
        $id = $request->user_id;

        $alldata = Business::where("user_id", $id)->get();

        if ($alldata->isEmpty()) {
            return APIResponse::error("Business data not found");
        }

        $data = [];

        foreach ($alldata as $dataItem) {
            $data[] = [
                "id" => $dataItem->id,
                "logo_image" => url("images/" . $dataItem->logo_image),
                "business_name" => $dataItem->business_name,
                "mobile_no" => $dataItem->mobile_no,
                "email" => $dataItem->email,
                "website" => $dataItem->website,
                "address" => $dataItem->address,
                "pincode" => $dataItem->pincode,
                "user_id" => $dataItem->user_id,
                "business_category_id" => $dataItem->business_category_id,
                "status" => $dataItem->status,
            ];
        }

        return APIResponse::success($data, "Data displayed");
    }
    public function allbussinesscategory()
    {
        $categoryget = Bussiness_category::all();
        if ($categoryget->isEmpty()) {
            return ApiResponse::error(null, "No data found");
        }
        $data = [];
        foreach ($categoryget as $dataa) {
            $data[] = [
                "id" => $dataa->id,
                "name" => $dataa->name,
            ];
        }
        return ApiResponse::success(
            $data,
            "Business category  displayed successfully"
        );
    }
    public function changebussiness(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required",
            "user_id" => "required",
            "status" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $business = Business::find($request->bussiness_id);

        if (!$business) {
            return ApiResponse::error("Business not found");
        }

        $business->status = 1;
        $business->save();

        Business::where("user_id", $request->user_id)
            ->where("id", "!=", $request->bussiness_id)
            ->update(["status" => 0]);

        $data = Business::where("user_id", $request->user_id)->get();

        return ApiResponse::success("Business status updated successfully");
    }
    public function deltebuussiness(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $business = Business::find($request->bussiness_id);

        if (!$business) {
            return ApiResponse::error("Business not found");
        }

        $business->delete();

        return ApiResponse::success(null . "Business Deleted successfully");
    }
}
