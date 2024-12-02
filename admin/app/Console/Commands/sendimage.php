<?php

namespace App\Console\Commands;
use App\Models\Image as Images;
use Illuminate\Http\Request;
use App\Models\Frame;
use App\Models\User;
use App\Models\Image as ImageModel;
use App\Models\Ratio;
use Illuminate\Support\Facades\File;
use App\Helpers\Whatsapp;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use App\Models\Business;
use App\Models\Personal;
use Log;

class sendimage extends Command
{
    protected $signature = "image:send";
    protected $description = "Send a daily image to all users";
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $user = User::where('user_type', '!=', 3)
     
     
        ->get();
    
      $today = Carbon::today()->toDateString();
    

        $imagesToday = ImageModel::where("date", $today)->where('type','post')->get();
    
         $baseUrl = "https://postermaker.bestdevelopmentteam.com";
    
     if ($imagesToday->isNotEmpty()) {
        foreach ($user as $userdata) {
           
            $randomImage = $imagesToday->random();
            $mainImageUrl = $baseUrl . "/images/" . $randomImage->image;
    
            try {
              
                $mainImage = Image::make($mainImageUrl);
                $mainImageWidth = $mainImage->width();
                $mainImageHeight = $mainImage->height();
                $newMainImage = clone $mainImage;
    
     
                $bussinessdata = Business::where("user_id", $userdata->id)->first();
                if ($bussinessdata) {
                    $logoUrl = $baseUrl . "/images/" . $bussinessdata->logo_image;
                } else {
                    $personaldata = Personal::where('user_id', $userdata->id)->first();
                    if ($personaldata) {
                        $logoUrl = $baseUrl . '/images/' . $personaldata->logo;
                    } else {
             
                        Log::info("No business or personal logo found for user ID: " . $userdata->id);
                        continue;
                    }
                }
    
        
                $logo = Image::make($logoUrl);
                $logoWidth = $logo->width();
                $logoHeight = $logo->height();
                $x = (int) (($mainImageWidth - $logoWidth) / 2);
                $y = 100;
    

                $newMainImage->insert($logo, "top-left", $x, $y);
    

                $uniqueFilename = 'output_' . uniqid() . '_frame_' . '.jpg';
                $outputImagePath = public_path("images/new/" . $uniqueFilename);
    

                $newMainImage->save($outputImagePath);

                $outputImageUrl = $baseUrl . "/images/new/" . $uniqueFilename;
    
               
                $this->info("Cron job executed successfully. Output image URL: {$outputImageUrl}");
    
            } catch (\Exception $e) {
             
                Log::error("Error processing image for user ID {$userdata->id}: " . $e->getMessage());
                continue;
            }
        }
    } else {
        $this->info("No images found for today.");
    }

    }

}


// $users = Business::all();
// foreach ($users as $user) {
//     $logoFileName = $user->logo_image;
//     $logoPath = public_path('images/' . $logoFileName);
//     $footerPath = public_path('images/footer.png');
//     $combinedImagePath = public_path('images/combined_' . $logoFileName);
//     if (file_exists($logoPath) && file_exists($footerPath)) {
//         $logo = Image::make($logoPath);
//         $footer = Image::make($footerPath);
//         $logo->resize($footer->width(), null, function ($constraint) {
//             $constraint->aspectRatio();
//         });
//         $footer->insert($logo, 'top');
//         $footer->save($combinedImagePath);
