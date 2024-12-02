<?php

namespace App\Http\Controllers\api;
use Carbon\Carbon;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\IsEmpty;

class DownloadController extends Controller
{
    public function download(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'download_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'bussiness_id' => 'nullable|exists:business,id',
            'user_id' => 'required|exists:users,id',
        
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        if ($request->hasFile('download_image')) {
            $file = $request->file('download_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
        } else {
            return response()->json(['error' => 'File not found'], 400);
        }
        $data = [
            'download_image' => $filename,
            'bussiness_id' => $request->input('bussiness_id'),
            'user_id' => $request->input('user_id'),
        ];
        $insertData = Download::create($data);
        if ($insertData) {
            return ApiResponse::success($insertData, 'File uploaded and registration successful');
        } else {
            return ApiResponse::error('data', 'Error saving data');
        }
    }
    public function delete_download_image(Request $request)
    {    

     $downloadid = $request->download_id;
        //  $extimages = Download::where('id', $downloadid)->first();
        //  $filePath2 = public_path('images/' . $extimages->download_image);
        //  if (file_exists($filePath2)) {
        //      unlink($filePath2);
        //  }
     
        $dlt = Download::where('id', $downloadid)->delete();

        if ($dlt === 0) {
            return ApiResponse::error("No data found for", 404);
        }
         $bussiness = [
            "id" => $dlt,
        ];
     if($dlt)
     {
     return APIResponse::success($bussiness, "data deleted succesffully");
     }
     
    }  
    public function get_download_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'bussiness_id' => 'nullable|exists:business,id',
        ]);
    
        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }
    
        $idu= $request->user_id;
        $idb= $request->bussiness_id;
        $timeRange = $request->input('time_range');
    
        $query = Download::where(function ($query) use ($idu, $idb) {
            $query->where('user_id', $idu)
                  ->orWhere('bussiness_id', $idb);
        });
        
        // Apply time range filter
        if ($timeRange) {
            switch ($timeRange) {
                case 'week':
                    $query->where('created_at', '>=', Carbon::now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', Carbon::now()->subMonth());
                    break;
                case 'year':
                    $query->where('created_at', '>=', Carbon::now()->subYear());
                    break;
                case 'since_beginning':
                    // No filter needed for 'since_beginning' - all records will be included
                    break;
            }
        }
        
        // Fetch the filtered results
        $downloads = $query->get();
        
        if ($downloads->isEmpty()) {
            return ApiResponse::error("No data found for the specified criteria", 404);
        }
        
        $data = [];
        foreach ($downloads as $download) {
            if ($download->user_id == $idu) {
                $data[] = [
                    'download_id' => $download->id,
                    "download_image" => url("images/" . $download->download_image),
                    "user_id" => $download->user_id,
                    "image_type" => $download->image_type,
                ];
            } else {
                $data[] = [
                    'download_id' => $download->id,
                    "download_image" => url("images/" . $download->download_image),
                    "bussiness_id" => $download->bussiness_id,
                    "user_id" => $download->user_id,
                    "image_type" => $download->image_type,
                ];
            }
        }
        
        $message = ($downloads->first()->user_id == $idu) ? "User data displayed successfully" : "Business data displayed successfully";
        
        return ApiResponse::success($data, $message);
    }
    public function clear_data(Request $request)
    {    

     $downloadid = $request-> id;
         $extimages = Download::where('user_id', $downloadid)->first();
         $filePath2 = public_path('images/' . $extimages->download_image);
         if (file_exists($filePath2)) {
             unlink($filePath2);
         }
     
         $dlt =   Download::where('user_id', $downloadid)->delete();
         $bussiness = [
            "id" => $dlt,
        ];
     if($dlt)
     {
     return APIResponse::success($bussiness, "data deleted succesffully");
     }
     else{
         return ApiResponse::error(null, "data not deleted succesffully");
     }
    }  

}
