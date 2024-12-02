<?php

namespace App\Http\Controllers\API;
use App\Models\Barnding;

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
class BrandingController extends Controller
{
    public function brandinglist(Request $request)
    {
        
         $data = Barnding::get()->map(function($item)
            {
                 $item->icon = url('images/Brandicons/' . $item->icon);
                return $item;
            });

        return response([
        
           'message' => 'Brandlist Displayed Successfully..!',
           'whatsapp_number' => '8849987778',
           'data' => $data,
           'statusCode' => 200
        
        ],200);
    }
}