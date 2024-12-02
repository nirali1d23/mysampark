<?php

namespace App\Http\Controllers\api;

use App\Helpers\ApiResponse;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Image;
use App\Models\ImageCategory;

use App\Models\Frame;

use Intervention\Image\Facades\Image as InterventionImage;

use App\Models\FrameRatioApp;

use Carbon\Carbon;

class ImageController extends Controller

{

 public function resizeMissingImages()

{

    // Fetch images with null in the 'resized_image' column

    $images = Image::whereNull('resized_image')->get();



    foreach ($images as $img) {

        $originalImagePath = public_path('images/' . $img->image);



        // Check if the original image file exists

        if (file_exists($originalImagePath)) {

            // Generate a unique name for the resized image

            $resizedImageName = pathinfo($img->image, PATHINFO_FILENAME) . '_small.' . pathinfo($img->image, PATHINFO_EXTENSION);

            $resizedImagePath = public_path('images/' . $resizedImageName);



            // Resize the image and save it

            InterventionImage::make($originalImagePath)

                ->resize(300, 200, function ($constraint) {

                    $constraint->aspectRatio();

                    $constraint->upsize();

                })

                ->save($resizedImagePath, 70);



            // Update the 'resized_image' column in the database

            $img->update(['resized_image' => $resizedImageName]);

        } else {

            // Log or handle the case where the original image file is missing

            \Log::warning("Original image not found for ID: {$img->id}");

        }

    }



    return "Resized images updated successfully!";

}

    public function allimages(Request $request)

    {



     

        // $images = Image::with('categoryimage')->get();



        // if ($images->isEmpty()) {

        //     return ApiResponse::error("No data found");

        // }

        

        // $data = [];  

        // $groupedImages = $images->groupBy('category_id');

        

        // foreach ($groupedImages as $category_id => $categoryImages) {

        //     $firstCategoryImage = $categoryImages->first()->categoryimage;

            

        //     if ($firstCategoryImage) {

        //         $category_name = $firstCategoryImage->name;

        //         $category_date = $firstCategoryImage->date;

        //     } else {

        //         $category_name = 'Unknown Category';

        //         $category_date = null;

        //     }

        

        //     $imageUrls = [];

        //     $stories = [];

        //     foreach ($categoryImages as $image) 

        //     {              

                



        //         $imageData = [

        //             "url" => url("images/" . $image->image), 

        //             "resized_image" =>url("images/" . $image->resized_image),

        //             "date" => $image->date,

        //             "color" => [

        //                 "name" => $image->name_colour ?? null,

        //                 "mobile" => $image->mobile_colour ?? null,

        //                 "address" => $image->address_colour ?? null,

        //                 "email" => $image->email_colour ?? null,

        //                 "website" => $image->website_colour ?? null,

        //                 "company" => $image->company_colour ?? null,

        //                 'address_icon_color' => $image->address_icon_color,

        //                 'email_icon_color' => $image->email_icon_color,

        //                 'mobile_icon_color' => $image->mobile_icon_color,

        //                 'web_icon_color' => $image->web_icon_color,

        //                 'logo_x' =>$image->logo_x,

        //                 'logo_y' =>$image->logo_y,

        //                 'logo_allingment' =>$image->logo_allingment,

        //                 'logo_size' =>$image->logo_size,

        //                 'logo_height' =>$image->logo_height,

        //                 'logo_width' =>$image->logo_width,

        

                       

        //             ]

         

        //         ];

        

        //         if ($image->type === 'post') {

        //             $imageUrls[] = $imageData;

        //         } elseif ($image->type === 'story') {

        //             $storyData = [

        //                 "url" => url("images/" . $image->image), 

        //                 "resized_image" =>url("images/" . $image->resized_image),

        //                 "date" => $image->date,

        //                 "color" => [

        //                     "name" => $image->name_colour ?? null,

        //                     "mobile" => $image->mobile_colour ?? null,

        //                     "address" => $image->address_colour ?? null,

        //                     "email" => $image->email_colour ?? null,

        //                     "website" => $image->website_colour ?? null,

        //                     "company" => $image->company_colour ?? null,

        //                     'address_icon_color' => $image->address_icon_color,

        //                 'email_icon_color' => $image->email_icon_color,

        //                 'mobile_icon_color' => $image->mobile_icon_color,

        //                 'web_icon_color' => $image->web_icon_color,

        //                 'logo_x' =>$image->logo_x,

        //                 'logo_y' =>$image->logo_y,

        //                 'logo_allingment' =>$image->logo_allingment,

        //                 'logo_size' =>$image->logo_size,

        //                 'logo_height' =>$image->logo_height,

        //                 'logo_width' =>$image->logo_width,

        

                       

        //                         ]

        //             ];

        //             $stories[] = $storyData;

        //         }

        //     }

        

        //     if (!empty($imageUrls)) {

        //         $data[] = [

        //             "category_id" => $category_id,

        //             "category_name" => $category_name,

        //             "category_date" => $category_date,

        //             "post" => $imageUrls, 

        //             "story" => $stories,

                  

        //         ];

        //     }

        // }



        $images = Image::with('categoryimage')->get();



if ($images->isEmpty()) {

    return ApiResponse::error("No data found");

}



$data = [];

$groupedImages = $images->groupBy('category_id');



$todaysDate = date('Y-m-d'); 





foreach ($groupedImages as $category_id => $categoryImages) {

    $firstCategoryImage = $categoryImages->first()->categoryimage;



    if ($firstCategoryImage) {

        $category_name = $firstCategoryImage->name;

        $category_date = $firstCategoryImage->date;

        $type = $firstCategoryImage->type; 
    } else {

        $category_name = 'Unknown Category';

        $category_date = null;

        $type = 0; // Default to show all if category type is unknown

    }



    $imageUrls = [];

    $stories = [];



    foreach ($categoryImages as $image) {



        // Filter images based on type and date

        if ($type == 1 && $category_date < $todaysDate) {

            continue; // Skip if type is 1 and date does not match today's date

        }



        $imageData = [

            "url" => url("images/" . $image->image),

            "resized_image" => url("images/" . $image->resized_image),

            "date" => $image->date,

            "color" => [

                "name" => $image->name_colour ?? null,

                "mobile" => $image->mobile_colour ?? null,

                "address" => $image->address_colour ?? null,

                "email" => $image->email_colour ?? null,

                "website" => $image->website_colour ?? null,

                "company" => $image->company_colour ?? null,

                'address_icon_color' => $image->address_icon_color,

                'email_icon_color' => $image->email_icon_color,

                'mobile_icon_color' => $image->mobile_icon_color,

                'web_icon_color' => $image->web_icon_color,

                'logo_x' => $image->logo_x,

                'logo_y' => $image->logo_y,

                'logo_allingment' => $image->logo_allingment,

                'logo_size' => $image->logo_size,

                'logo_height' => $image->logo_height,

                'logo_width' => $image->logo_width,

            ]

        ];



        if ($image->type === 'post') {

            $imageUrls[] = $imageData;

        } elseif ($image->type === 'story') {

            $storyData = $imageData; // Use the same structure for stories

            $stories[] = $storyData;

        }

    }



    if (!empty($imageUrls) || !empty($stories)) {

        $data[] = [

            "category_id" => $category_id,

            "category_name" => $category_name,

            "category_date" => $category_date,

            "post" => $imageUrls,

            "story" => $stories,

        ];

    }

}

       return ApiResponse::success([

            'data' => $data,

        ], "Images displayed successfully");

        

        return ApiResponse::success([

            'data' => $data, 

        ], "images displayed successfully");    

    }

    

    public function frames(Request $request)

    {



        $data = Frame::with('ratiosapp')->with('frame_icon')->limit(10)->get();

        



        $data->transform(function ($frame) {

            // Append URL to image path

            $frame->image = url("images/Bottom Bar Assets/" . $frame->fram_path);

        

            // Initialize organizedRatios with default values

            $organizedRatios = [

                'name' => null,

                'mobile' => null,

                'address' => null,

                'email' => null,

                'website' => null,

                'company' => null,

            ];

        

            // Loop through ratiosapp to organize data based on element_type

            foreach ($frame->ratiosapp as $ratio) {

                $elementData = [

                    'x' => $ratio->X_Left,

                    'y' => $ratio->Y_Top,

                    'color' => $ratio->font_color,

                    'size' => $ratio->font_size,

                    'monst' => $ratio->monst,

                    'letter' => $ratio->letter,

                    'height' => $ratio->height,

                    'width' => $ratio->width,

                    'reverse_value' =>$ratio->reverse_value

                ];

        

                // Only assign data if no key value is null (you can customize this condition)

                if (!is_null($ratio->X_Left) && !is_null($ratio->Y_Top) && !is_null($ratio->font_color)) {

                    // Use the element_type dynamically to assign the values

                    switch ($ratio->element_type) {

                        case 'name':

                            $organizedRatios['name'] = $elementData;

                            break;

                        case 'mobile':

                            $organizedRatios['mobile'] = $elementData;

                            break;

                        case 'address':

                            $organizedRatios['address'] = $elementData;

                            break;

                        case 'email':

                            $organizedRatios['email'] = $elementData;

                            break;

                        case 'website':

                            $organizedRatios['website'] = $elementData;

                            break;

                        case 'company':

                            $organizedRatios['company'] = $elementData;

                            break;

                    }

                }

            }

        

            // Assign the organized ratios to the frame object

            $frame->elements = $organizedRatios;

        

            // Loop through frame_icon to append the URL to each icon_image

            foreach ($frame->frame_icon as $icon) {

                // $icon->reverse_icon_value = filter_var($icon->reverse_icon_value, FILTER_VALIDATE_BOOLEAN);

                $icon->icon_image = url("images/Bottom Bar Assets/Icons/" . $icon->icon_image);

            }

        

            // Optionally, remove the 'ratiosapp' relationship data from the response

            unset($frame->ratiosapp);

        

            return $frame;

        });

        

        return ApiResponse::success($data, "Frames displayed successfully");

        

    }

    

    

     public function datefilterimagee(Request $request)

    {

        $date = $request->date;

        
       $images =  Image::where('date',$date)->get();



       if ($images)        

       {

       

        $data = [];

        $groupedImages = $images->groupBy('category_id');



        foreach ($groupedImages as $category_id => $categoryImages) {



         $firstCategoryImage = $categoryImages->first()->categoryimage;

            

            if ($firstCategoryImage) {

                $category_name = $firstCategoryImage->name;

                $category_date = $firstCategoryImage->date;

            } else {

      

        $category_name = 'Unknown Category';

        $category_date = null;

            }

            $imageUrls = [];

            $stories = [];

        

            foreach ($categoryImages as $image) 

            {

                $imageData = [

                    "url" => url("images/" . $image->image), 

                    "resized_image" =>url("images/" . $image->resized_image),

                    "date" => $image->date,

                    "color" => [

                        "name" => $image->name_colour ?? null,

                        "mobile" => $image->mobile_colour ?? null,

                        "address" => $image->address_colour ?? null,

                        "email" => $image->email_colour ?? null,

                        "website" => $image->website_colour ?? null,

                        "company" => $image->company_colour ?? null,

                        'address_icon_color' => $image->address_icon_color,

                        'email_icon_color' => $image->email_icon_color,

                        'mobile_icon_color' => $image->mobile_icon_color,

                        'web_icon_color' => $image->web_icon_color,

                        'logo_x' =>$image->logo_x,

                        'logo_y' =>$image->logo_y,

                        'logo_allingment' =>$image->logo_allingment,

                        'logo_size' =>$image->logo_size,

                        'logo_height' =>$image->logo_height,

                        'logo_width' =>$image->logo_width,

        

                       

                    ]

                ];

        

                if ($image->type === 'post') {

                    $imageUrls[] = $imageData;

                } elseif ($image->type === 'story') {

                    $storyData = [

                        "url" => url("images/" . $image->image), 

                        "resized_image" =>url("images/" . $image->resized_image),

                        "date" => $image->date,

                        "color" => [

                            "name" => $image->name_colour ?? null,

                            "mobile" => $image->mobile_colour ?? null,

                            "address" => $image->address_colour ?? null,

                            "email" => $image->email_colour ?? null,

                            "website" => $image->website_colour ?? null,

                            "company" => $image->company_colour ?? null,

                            'address_icon_color' => $image->address_icon_color,

                        'email_icon_color' => $image->email_icon_color,

                        'mobile_icon_color' => $image->mobile_icon_color,

                        'web_icon_color' => $image->web_icon_color,

                        'logo_x' =>$image->logo_x,

                        'logo_y' =>$image->logo_y,

                        'logo_allingment' =>$image->logo_allingment,

                        'logo_size' =>$image->logo_size,

                        'logo_height' =>$image->logo_height,

                        'logo_width' =>$image->logo_width,

        

                       

                                ]

                    ];

                    $stories[] = $storyData;

                }

            }

        

            if (!empty($imageUrls)) {

                $data[] = [

                    "category_id" => $category_id,

                    "category_name" => $category_name,

                    "category_date" => $category_date,

                    "post" => $imageUrls, 

                    "story" => $stories,

                  

                ];

            }



       return ApiResponse::success($data, "Images Displayed successfully");

      }



      return ApiResponse::success($data,"no data Found");





     }

    }

    public function datefilterimage(Request $request)
    {
        $date = $request->date;

        // Fetch categories with the given date and their associated images
        $categories = ImageCategory::where('date', $date)->with('images')->get();

        $data = [];

        foreach ($categories as $category) {
            $category_name = $category->name; // Category name from categories table
            $category_date = $category->date; // Date from categories table
            $category_id = $category->id; // Category ID

            // Group images by type ('post' or 'story')
            $imageUrls = [];
            $stories = [];

            foreach ($category->images as $image) {
                $imageData = [
                    "url" => url("images/" . $image->image),
                    "resized_image" => url("images/" . $image->resized_image),
                    "date" => $image->date,
                    "color" => [
                        "name" => $image->name_colour ?? null,
                        "mobile" => $image->mobile_colour ?? null,
                        "address" => $image->address_colour ?? null,
                        "email" => $image->email_colour ?? null,
                        "website" => $image->website_colour ?? null,
                        "company" => $image->company_colour ?? null,
                        'address_icon_color' => $image->address_icon_color,
                        'email_icon_color' => $image->email_icon_color,
                        'mobile_icon_color' => $image->mobile_icon_color,
                        'web_icon_color' => $image->web_icon_color,
                        'logo_x' => $image->logo_x,
                        'logo_y' => $image->logo_y,
                        'logo_allingment' => $image->logo_allingment,
                        'logo_size' => $image->logo_size,
                        'logo_height' => $image->logo_height,
                        'logo_width' => $image->logo_width,
                    ],
                ];

                if ($image->type === 'post') {
                    $imageUrls[] = $imageData;
                } elseif ($image->type === 'story') {
                    $stories[] = $imageData;
                }
            }

            if (!empty($imageUrls) || !empty($stories)) {
                $data[] = [
                    "category_id" => $category_id,
                    "category_name" => $category_name,
                    "category_date" => $category_date,
                    "post" => $imageUrls,
                    "story" => $stories,
                ];
            }
        }


        return ApiResponse::success($data, "Images displayed successfully");
    
    }

}

