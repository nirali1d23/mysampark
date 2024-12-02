<?php

namespace App\Http\Controllers\api;
use App\Models\Bussiness_category;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\ProductImages;
use App\Models\Service;
use App\Models\ServiceImges;
use App\Models\bussinesimage;
use App\Models\Testimonial;
use App\Models\bussinesstime;
use App\Models\Product;
use App\Models\Sociallinks;
use App\Models\Appointment;
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
    public function store_bussiness_time(Request $request)
    {

        foreach ($request->hours as $hour) {
            bussinesstime::create([
                'business_id' => $request->business_id,
                'is_open' => $hour['is_open'],
                'day' => $hour['day'],
                'start_time' => $hour['start_time'],
                'end_time' => $hour['end_time'],
            ]);
        }
        return response()->json(['message' => 'Business hours saved successfully.'], 200);

    
    }
    public function display_bussiness_time(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required",
         
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = bussinesstime::where('business_id', $request->bussiness_id)->get();
     

        if ($data->isEmpty()) 
        {
        
            return response()->json([
                "message" => "No business hours found for the provided business ID.",
                "data" => [],
            ], 404);
        }
    
    
            return ApiResponse::success(
                $data,
                "Business Image Added successfully"
            );

        

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

    public function base64Image(Request $request)
    {
        if ($request->has("file")) {
            $base64File = $request->file;
    
            // Check if the base64 string is for an image or a video
            if (preg_match("/^data:image\/(\w+);base64,/", $base64File, $type)) {
                // It's an image
                $base64File = substr($base64File, strpos($base64File, ",") + 1);
                $type = strtolower($type[1]);  // Image type (e.g., jpg, png, etc.)
                $fileType = 'image';
            } elseif (preg_match("/^data:video\/(\w+);base64,/", $base64File, $type)) {
                // It's a video
                $base64File = substr($base64File, strpos($base64File, ",") + 1);
                $type = strtolower($type[1]);  // Video type (e.g., mp4, avi, etc.)
                $fileType = 'video';
            } else {
                return response()->json([
                    "data" => [],
                    "message" => "Invalid base64 string. Only image or video is allowed.",
                    "status" => 400,
                ]);
            }
    
            // Replace spaces with plus signs for base64 compatibility
            $base64File = str_replace(" ", "+", $base64File);
            $fileData = base64_decode($base64File);
    
            // Check if base64 decoding was successful
            if ($fileData === false) {
                return response()->json([
                    "data" => [],
                    "message" => "Base64 decode failed",
                    "status" => 400,
                ]);
            }
    
            // Generate a unique filename for the file
            $fileName = uniqid() . '.' . $type;  // Save with original file extension (e.g., mp4, jpg, png)
    
            // Define the directory based on the file type
            if ($fileType === 'image') {
                $directory = public_path("images/business/");
                $url = url("images/business/" . $fileName);

            } else {
                $directory = public_path("images/business/videos/");
                $url = url("images/business/videos" . $fileName);

            }
    
            // Ensure the directory exists
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
    
            // Define the full file path
            $filePath = $directory . $fileName;
    
            // Save the file
            if (file_put_contents($filePath, $fileData)) {
                return response()->json([
                    "data" => $fileName,
                    "url" => $url,
                    "message" => ucfirst($fileType) . " uploaded successfully",
                    "status" => 200,
                ]);
            } else {
                return response()->json([
                    "data" => [],
                    "message" => "Failed to save " . $fileType,
                    "status" => 500,
                ]);
            }
        } else {
            return response()->json([
                "data" => [],
                "message" => "File not found in the request",
                "status" => 400,
            ]);
        }
    }
    
     
    public function add_bussiness_images(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required",
            "image" => "required",
        ]);

        foreach($request->image as $item)

        {
            $data = new bussinesimage;

              $data->image  =  $item['image'];
              $data->bussiness_id  =  $request->bussiness_id;
              $data->type  =  0;
              $data->save();
        }

        foreach($request->video as $itemm)

        {
            $dataa = new bussinesimage;

              $dataa->image  =  $itemm['video'];
              $dataa->bussiness_id  =  $request->bussiness_id;
              $dataa->type  =  1;
              $dataa->save();
        }

        return ApiResponse::success(
            $data,
            "Business Image Added successfully"
        );
    }

    public function display_bussiness_images(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required",
         
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = bussinesimage::where('bussiness_id',$request->bussiness_id)->get();

        if($data)
        {
            foreach($data as $item)
            {
                
                 if($item->type == 1)
                 {
                     $item->image = url("images/business/video/".$item->image);
                 }

                 $item->image = url("images/business/".$item->image);
            
            }

            return ApiResponse::success(
                $data,
                "Business Image Added successfully"
            );
        }

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
    public function product_add(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required",
            "name" => "required",
            "description" => "required",
        
            "images" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        


       

         $data = new Product;
         $data->bussiness_id = $request->bussiness_id;
         $data->name = $request->name;
         $data->description = $request->description;
         $data->starting_price = $request->starting_price;

         $data->save();

         if ($request->hasFile('images')) {
            foreach ($request->file('images') as $uploadedImage) {
                // Generate unique filename
                $unique = uniqid();
                $filename = time() . "." . $unique . "." . $uploadedImage->extension();
        
                // Move the file to the desired directory
                $uploadedImage->move(public_path("images/products"), $filename);
        
                // Save the file information in the database
                $image = new ProductImages;
                $image->product_id = $data->id;
                $image->images = $filename;
                $image->save();
            }
        }
        

       

         return ApiResponse::success($data, "Product Added successfully");


         
    }
    public function testimonial_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required",
            "name" => "required",
            "designation" => "required",
            "company" => "required",
            "review" => "required",
            "image" => "required",
            "rate_star" => "required",
          
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->hasFile('image')) {
   
                // Generate unique filename
                $unique = uniqid();
                $filename = time() . "." . $unique . "." . $request->image->extension();
    
                // Move the file to the desired directory
                 $request->image->move(public_path("images/testimonial"), $filename);
    
            }
        
        $data = new Testimonial;
        $data->bussiness_id = $request->bussiness_id;
        $data->name = $request->name;
        $data->designation = $request->designation;
        $data->company = $request->company;
        $data->review = $request->review;
        $data->rate_star = $request->rate_star;
        $data->image = $filename;
        $data->save();



        return ApiResponse::success($data, "Testimonial added successfully");

    } 
    public function testimonial_display(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required",
           
          
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
       $data = Testimonial::where('bussiness_id',$request->bussiness_id)->get();

       return ApiResponse::success($data, "Testimonial added successfully");

    }
    public function product_addd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required",
            "name" => "required",
            "description" => "required",
            "images" => "nullable|array",  // images are optional for update
            "images.*" => "nullable|image|mimes:jpg,jpeg,png|max:2048", // validate individual images
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        
    
        
            $data = new Product;
        

        // Update or create product data
        $data->bussiness_id = $request->bussiness_id;
        $data->name = $request->name;
        $data->description = $request->description;
        $data->starting_price = $request->starting_price;

        $data->save();

        // Handle images upload if present
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $uploadedImage) {
                // Generate unique filename
                $unique = uniqid();
                $filename = time() . "." . $unique . "." . $uploadedImage->extension();

                // Move the file to the desired directory
                $uploadedImage->move(public_path("images/products"), $filename);

                // Save the file information in the ProductImages table
                $image = new ProductImages;
                $image->product_id = $data->id;
                $image->images = $filename;
                $image->save();
            }
        }

        // Return success response with product data
        return ApiResponse::success($data, "Product " . ($request->id ? "updated" : "added") . " successfully");
    }
    public function service_add(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required",
            "name" => "required",
            "description" => "required",
            "images" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

    

         $data = new Service;
         $data->bussiness_id = $request->bussiness_id;
         $data->name = $request->name;
         $data->description = $request->description;
         $data->starting_price = $request->starting_price;

         $data->save();

         if ($request->hasFile('images')) {
            foreach ($request->file('images') as $uploadedImage) {
                // Generate unique filename
                $unique = uniqid();
                $filename = time() . "." . $unique . "." . $uploadedImage->extension();
        
                // Move the file to the desired directory
                $uploadedImage->move(public_path("images/service"), $filename);
        
                // Save the file information in the database
                $image = new ServiceImges;
                $image->service_id = $data->id;
                $image->images = $filename;
                $image->save();
            }
        }
        

       

         return ApiResponse::success($data, "service Added successfully");


         
    }
    public function product_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required",
           
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = Product::with('prodcutimages')->where('bussiness_id',$request->bussiness_id)->get();

        if ($data->isNotEmpty()) {
            return ApiResponse::success(
                $data,
                "Product displayed successfully"
            );
        }

        return ApiResponse::error("Product not found");



    }
    public function service_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required",
           
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = Service::with('serviceimages')->where('bussiness_id',$request->bussiness_id)->get();

        if ($data->isNotEmpty()) 
        {
            return ApiResponse::success(
                $data,
                "service  displayed successfully"
            );
        }

        return ApiResponse::error("service not found");


    }

    public function add_socialmedia_links(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required|integer",
          
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        foreach($request->data as $item)
        {
            
                 $data =  new  Sociallinks;
                 $data->bussiness_id = $request->bussiness_id;
                $data->title = $item['title'];
                $data->link = $item['link'];

               $data->save();                                                                   
        }


         foreach($request->appointment as $items)
         {

            $dataa =  new  Appointment;
            $dataa->bussiness_id = $request->bussiness_id;
           $dataa->title = $items['title'];
           $dataa->link = $items['link'];

          $dataa->save();
         }

        return ApiResponse::success($data, "Social media links Added successfully");



    }



  
    public function display_social_media_links(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "bussiness_id" => "required",
           
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $data = Sociallinks::where('bussiness_id',$request->bussiness_id)->get();
        $data2 = Appointment::where('bussiness_id',$request->bussiness_id)->get();
       
            
        return response( [
            'message' => 'Social media links displayed successfully',
            'success' => true,
            'statusCode' => 200,
            'links' => $data,
            'appointment' => $data2
            ], 200 );

    }

    

        // return ApiResponse::error("links not found");

    }

