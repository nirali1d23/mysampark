<?php







namespace App\Http\Controllers;



use Intervention\Image\Facades\Image as InterventionImage;



use Maatwebsite\Excel\Facades\Excel;



use App\Imports\FrameImport;



use Illuminate\Http\Request;



use Illuminate\Support\Facades\Storage;



use App\Models\UserSendImage;



use App\Models\Business;



use App\Models\Image;



use App\Models\ImageCategory;



use App\Models\FrameRatioApp;



use App\Models\Frame;



use App\Models\Frameicon;



use Illuminate\Support\Facades\File;





 // Your custom import class

use Session;



use FFMpeg\FFMpeg;



use FFMpeg\Format\Video\X264;







class createimageController extends Controller



{



    public function showimage(Request $request)



    {



         return view('admin.showimage');



    }



    public function storesnapsot(Request $request)



    {



        if ($request->hasFile('image')) 



        {



            $image = $request->file('image');



            $path = $image->move(public_path('snapshots'), 'snapshot_'.time().'.png');       



            $this->sendEmailToUsers($path);



        }



        return response()->json(['success' => true]);



    }



    public function sendEmailToUsers($imagePath)



    {



        $users = \App\Models\User::all(); // Assuming you have a User model



        foreach ($users as $user) {



            \Mail::to($user->email)->send(new \App\Mail\SnapshotMail($imagePath));



        }



    }



    public function display(Request $request)



    {



        if($request->ajax()){



            $columns = array( 



                0 =>'id', 



                1 =>'image',



        



            );

        $totalData = Image::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');



        $start = $request->input('start');



        $order = $columns[$request->input('order.0.column')];



        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))



        {            

        $posts = Image::offset($start)



                    ->limit($limit)



                    ->orderBy('created_at', 'desc') 



                    ->get();



        }

        else 

        {

        $search = $request->input('search.value');

        $posts =  Image::where('id','LIKE',"%{$search}%")

                        ->orWhere('image', 'LIKE',"%{$search}%")

                        ->orWhere('type', 'LIKE',"%{$search}%")

                        ->offset($start)

                        ->limit($limit)

                        ->orderBy('created_at', 'desc') 

                        ->get();







        $totalFiltered = Image::where('id','LIKE',"%{$search}%")



                        ->orWhere('image', 'LIKE',"%{$search}%")



                        ->orWhere('type', 'LIKE',"%{$search}%")



                        ->count();



        }







        $data = array();



        if(!empty($posts))



        {



        foreach ($posts as $post)



        {



            $nestedData['id'] = $post->id;



                        $nestedData['image'] = $post->image;



                        $nestedData['type'] = $post->type;



            $data[] = $nestedData;



        }



        }



        $json_data = array(



                "draw"            => intval($request->input('draw')),  



                "recordsTotal"    => intval($totalData),  



                "recordsFiltered" => intval($totalFiltered), 



                "data"            => $data   



                );







         return response()->json($json_data);







      }







     



        return view('admin.imagedisplay');



    



    }



    public function saveBusinessImage(Request $request)



    {



            $request->validate([



                'business_id' => 'required|integer|exists:businesses,id',



                'image_data' => 'required|string'



            ]);







            $imageData = $request->input('image_data');



            $businessId = $request->input('business_id');



            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));



            $filename = 'business_image_' . $businessId . '_' . time() . '.png';



            Storage::disk('public')->put($filename, $imageData);



            UserSendImage::create([



                'business_id' => $businessId,



                'image_path' => $filename



            ]);



         return response()->json(['message' => 'Image saved successfully']);



    }



public function createimage(Request $request)

{

    return view('admin.createimage');

}



public function createimages(Request $request)

{



    $categories = ImageCategory::all();



    $frameImages = array_diff(scandir(public_path('frames')), ['.', '..']);







    $frameImages = array_values($frameImages); 







    // Filter out non-image files (optional)



    



    



    return view('admin.imagecreate',compact('categories','frameImages'));



}

public function testframedelete(Request $request)

{



    $imageName = $request->input('image'); // Get the image filename



    



    // Define the path to the frames folder



    $imagePath = public_path('frames/' . $imageName);







    // Check if the image exists and delete it



    if (File::exists($imagePath)) {



        File::delete($imagePath); // Delete the image file



        return response()->json(['success' => true]);



    } else {



        return response()->json(['success' => false]);



    }







}

public function testframe(Request $request)

{



    $images = glob(public_path('frames/*.*'));



    return view('admin.testframedisplay', compact('images'));







}

public function testframeadd(Request $request)

{







    if($request->has('image'))



    {



        $image = $request->file('image');



        $imageName = time() . '.' . $image->getClientOriginalExtension();



        $image->move(public_path('frames/'), $imageName);



    



    }



    



    session::flash('code','success');



    return redirect('testframe')->with('status','frame Added successfully');







}

public function storeimage_api(Request $request)

{

    $request->validate([

        'category_id' => 'required',

        'images' => 'required',

        'type' => 'required',

        'name_colour' => 'nullable|string|max:255',

        'mobile_colour' => 'nullable|string|max:255',

        'address_colour' => 'nullable|string|max:255',

        'email_colour' => 'nullable|string|max:255',

        'website_colour' => 'nullable|string|max:255',

        'company_colour' => 'nullable|string|max:255',

        'address_icon_color' => 'nullable|string|max:255',

        'email_icon_color' => 'nullable|string|max:255',

        'mobile_icon_color' => 'nullable|string|max:255',

        'web_icon_color' => 'nullable|string|max:255',

        'logo_x' => 'nullable|string|max:255',

        'logo_y' => 'nullable|string|max:255',

        'logo_allingment' => 'nullable|string|max:255',

        'logo_size' => 'nullable|string|max:255',



    ]);



        if ($request->hasFile('images')) 

        {

            $file = $request->file('images');



    

        // Generate unique file names

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $resizedImageName = time() . '_' . uniqid() . '_small.' . $file->getClientOriginalExtension();



        // Define paths

        $originalPath = public_path('images/' . $fileName);

        $resizedPath = public_path('images/' . $resizedImageName);



        // Save original image

        $file->move(public_path('images'), $fileName);



        // Resize and save smaller version

        InterventionImage::make($originalPath)

            ->resize(300, 200, function ($constraint) {

                $constraint->aspectRatio();

                $constraint->upsize();

            })

            ->save($resizedPath, 70);



        $data =  Image::create([

            'category_id' => $request->category_id,

            'image' => $fileName,

            'date' => $request->date,

            'type' => $request->type,

            'resized_image' => $resizedImageName,

            'name_colour' => $request->name_colour,

            'mobile_colour' => $request->mobile_colour,

            'address_colour' => $request->address_colour,

            'email_colour' => $request->email_colour,

            'website_colour' => $request->website_colour,

            'company_colour' => $request->company_colour,

            'address_icon_color' => $request->address_icon_color,

            'email_icon_color' => $request->email_icon_color,

            'mobile_icon_color' => $request->mobile_icon_color,

            'web_icon_color' => $request->web_icon_color,

            'logo_x' => $request->logo_x,

            'logo_y' => $request->logo_y,

            'logo_allingment' => $request->logo_allingment,

            'logo_size' => $request->logo_size,

            'logo_width' => $request->logo_width,

            'logo_height' => $request->logo_height,

        ]);

    



    return response()->json([ 'status' => 'success','message' => 'Images uploaded and saved successfully', 'data' => $data,

], 200);

}



return response()->json(['message' => 'No images found'], 400);



}

public function updateimage_api(Request $request)

{

    $request->validate([

        'id' =>  'required',

        'category_id' => 'required|integer',

        'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

   

        'type' => 'required|string|max:255',

        'name_colour' => 'nullable|string|max:255',

        'mobile_colour' => 'nullable|string|max:255',

        'address_colour' => 'nullable|string|max:255',

        'email_colour' => 'nullable|string|max:255',

        'website_colour' => 'nullable|string|max:255',

        'company_colour' => 'nullable|string|max:255',

        'address_icon_color' => 'nullable|string|max:255',

        'email_icon_color' => 'nullable|string|max:255',

        'mobile_icon_color' => 'nullable|string|max:255',

        'web_icon_color' => 'nullable|string|max:255',

        'logo_x' => 'nullable|string|max:255',

        'logo_y' => 'nullable|string|max:255',

        'logo_allingment' => 'nullable|string|max:255',

        'logo_size' => 'nullable|string|max:255',

    ]);



    try {

        // Locate the record

        $imageData = Image::findOrFail($request->id);



        // Handle image update

        if ($request->hasFile('images')) {

            $file = $request->file('images');



            // Generate unique file names

            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $resizedImageName = time() . '_' . uniqid() . '_small.' . $file->getClientOriginalExtension();



            // Define paths

            $originalPath = public_path('images/' . $fileName);

            $resizedPath = public_path('images/' . $resizedImageName);



            // Save original image

            $file->move(public_path('images'), $fileName);



            // Resize and save smaller version

            InterventionImage::make($originalPath)

                ->resize(300, 200, function ($constraint) {

                    $constraint->aspectRatio();

                    $constraint->upsize();

                })

                ->save($resizedPath, 70);



            // Delete old images if exist

            if ($imageData->image && file_exists(public_path('images/' . $imageData->image))) {

                unlink(public_path('images/' . $imageData->image));

            }

            if ($imageData->resized_image && file_exists(public_path('images/' . $imageData->resized_image))) {

                unlink(public_path('images/' . $imageData->resized_image));

            }



            // Update new image names

            $imageData->image = $fileName;

            $imageData->resized_image = $resizedImageName;

        }



        // Update other fields

        $imageData->update([

            'category_id' => $request->category_id,

            'date' => $request->date,

            'type' => $request->type,

            'name_colour' => $request->name_colour,

            'mobile_colour' => $request->mobile_colour,

            'address_colour' => $request->address_colour,

            'email_colour' => $request->email_colour,

            'website_colour' => $request->website_colour,

            'company_colour' => $request->company_colour,

            'address_icon_color' => $request->address_icon_color,

            'email_icon_color' => $request->email_icon_color,

            'mobile_icon_color' => $request->mobile_icon_color,

            'web_icon_color' => $request->web_icon_color,

            'logo_x' => $request->logo_x,

            'logo_y' => $request->logo_y,

            'logo_allingment' => $request->logo_allingment,

            'logo_size' => $request->logo_size,

            'logo_width' => $request->logo_width,

            'logo_height' => $request->logo_height,

        ]);



        return response()->json([

            'status' => 'success',

            'message' => 'Image updated successfully',

            'data' => $imageData,

        ], 200);

    } catch (\Exception $e) {

        return response()->json([

            'status' => 'error',

            'message' => 'An error occurred while updating the image',

            'error' => $e->getMessage(),

        ], 500);

    }

}

public function dispalyimage_api(Request $request)

{



    $data = Image::orderBy('id', 'desc')->get()->map(function ($item) {
        $item->image = url('images/' . $item->image);
        $item->resized_image = url('images/' . $item->resized_image);
        return $item;
    });
    

        

            return response()->json([

            'status' => 'true',

            'data' => $data,

            'message' => 'Image Displayed !!',

        ], 200);

}

public function deleteimage_api(Request $request)

{

    



        $request->validate([



            'id' => 'required',

        ]);



            $data = Image::find($request->id);

            if($data)

            {

                $data->delete();

                return response()->json([

                'status' => 'true',

                'message' => 'Image Deleted !!',

            ], 200);



            }

            return response()->json([

            'status' => 'false',

            'message' => 'Image Not found !!',



        ], 200);











}

public function storeimage(Request $request)

{    





    if ($request->has('images')) {



    







        $images = $request->file('images');



        



    



        foreach ($images as $file) {



            



            



            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();



            $resizedImageName = time() . '_' . uniqid() . '_small.' . $file->getClientOriginalExtension();



            



            







            $originalPath = public_path('images/' . $fileName);



            $resizedPath = public_path('images/' . $resizedImageName);







            $file->move(public_path('images'), $fileName);







            InterventionImage::make($originalPath)



                ->resize(300, 200, function ($constraint) {



                    $constraint->aspectRatio();



                    $constraint->upsize();



                })



                ->save($resizedPath, 70);







            // Save to database



        Image::create([



                'category_id' => $request->category_id,



                'image' => $fileName,



                'date' => $request->date,



                'type' => $request->type,



                'resized_image' => $resizedImageName,



                'name_colour' => $request->name_colour,



                'mobile_colour' => $request->mobile_colour,



                'address_colour' => $request->address_colour,



                'email_colour' => $request->email_colour,



                'website_colour' => $request->website_colour,



                'company_colour' => $request->company_colour,



                'address_icon_color' => $request->address_icon_color,



                'email_icon_color' => $request->email_icon_color,



                'mobile_icon_color' => $request->mobile_icon_color,



                'web_icon_color' => $request->website_icon_color,



                'logo_x' =>$request->logo_x,

                'logo_y' =>$request->logo_y,

                'logo_allingment' =>$request->logo_allingment,

                'logo_size' =>$request->logo_size,

                'logo_height' =>$request->logo_height,

                'logo_width' =>$request->logo_width,







            ]);



        



        }



        }







                session::flash('code','success');







                return redirect('image')->with('status','image Added successfully');







}

public function store(Request $request)

{



    $request->validate([



        'image' => 'required|image',



        'business_id' => 'required|integer'



    ]);



    $path = $request->file('image')->store('images');



    $userSendImage = new UserSendImage;



    $userSendImage->business_id = $request->business_id;



    $userSendImage->image_path = $path;



    $userSendImage->save();



    return response()->json(['success' => true, 'message' => 'Image saved successfully']);



}

public function store_frame(Request $request)

{

    if ($request->has('frame')) 

    {

        $image = $request->file('frame');



        $imageName = time() . '.' . $image->getClientOriginalExtension();



        $image->move(public_path('images/Bottom Bar Assets'), $imageName);



    



        // Store frame in the frames table



        $frame = Frame::create([



            'fram_path' => $imageName



        ]);



        



        // Prepare and store icons



        $icons = [



            'address' => [



                'icon' => $request->file('address_icon'),



                'x' => $request->input('address_x'),



                'y' => $request->input('address_y'),



                'color' => $request->input('address_color'),

                'size' => $request->input('address_size'),





            ],



            'mobile' => [



                'icon' => $request->file('mobile_icon'),



                'x' => $request->input('mobile_x'),



                'y' => $request->input('mobile_y'),



                'color' => $request->input('mobile_color'),



                'size' => $request->input('mobile_size'),



            ],



            'website' => [



                'icon' => $request->file('website_icon'),



                'x' => $request->input('website_x'),



                'y' => $request->input('website_y'),



                'color' => $request->input('website_color'),

                'size' => $request->input('website_size'),



            ],



            'mail' => [

                'icon' => $request->file('mail_icon'),

                'x' => $request->input('mail_x'),

                'y' => $request->input('mail_y'),

                'color' => $request->input('mail_color'),

                'size' => $request->input('mail_size'),

            ]



        ];

        foreach ($icons as $type => $data) {

            if ($data['icon']) {

                $iconName = time() . '_' . $type . '.' . $data['icon']->getClientOriginalExtension();

                $data['icon']->move(public_path('images/Bottom Bar Assets/Icons'), $iconName);



                // Store icon in the frame_icons table



                $dataaaa[] =   Frameicon::create([

                    'frame_id' => $frame->id,

                    'icon_type' => $type,

                    'x' => $data['x'],

                    'y' => $data['y'],

                    'color' => $data['color'],

                    'size' => $data['size'],

                    'icon_image' => $iconName,



                ]);



            }



        }



        



    }



    



    session::flash('code','success');



    return redirect('frame')->with('status','frame Added successfully');



        



}

public function store_frame_api(Request $request)

{





    $request->validate([

        'frame' => 'required|file|mimes:jpg,jpeg,png',

        'address_icon' => 'nullable|file|mimes:jpg,jpeg,png',

        'address_x' => 'nullable|numeric',

        'address_y' => 'nullable|numeric',

        'address_color' => 'nullable|string',

        'mobile_icon' => 'nullable|file|mimes:jpg,jpeg,png',

        'mobile_x' => 'nullable|numeric',

        'mobile_y' => 'nullable|numeric',

        'mobile_color' => 'nullable|string',

        'website_icon' => 'nullable|file|mimes:jpg,jpeg,png',

        'website_x' => 'nullable|numeric',

        'website_y' => 'nullable|numeric',

        'website_color' => 'nullable|string',

        'mail_icon' => 'nullable|file|mimes:jpg,jpeg,png',

        'mail_x' => 'nullable|numeric',

        'mail_y' => 'nullable|numeric',

        'mail_color' => 'nullable|string',

    ]);

    try {



        // Handle frame image

        $image = $request->file('frame');

        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('images/Bottom Bar Assets'), $imageName);

        // Store frame in the frames table

        $frame = Frame::create([

            'fram_path' => $imageName

        ]);

        // Prepare and store icons

        $icons = [

            'address' => [



                'icon' => $request->file('address_icon'),



                'x' => $request->input('address_x'),



                'y' => $request->input('address_y'),



                'color' => $request->input('address_color'),



            ],



            'mobile' => [



                'icon' => $request->file('mobile_icon'),



                'x' => $request->input('mobile_x'),



                'y' => $request->input('mobile_y'),



                'color' => $request->input('mobile_color'),



            ],



            'website' => [



                'icon' => $request->file('website_icon'),



                'x' => $request->input('website_x'),



                'y' => $request->input('website_y'),



                'color' => $request->input('website_color'),



            ],



            'mail' => [



                'icon' => $request->file('mail_icon'),



                'x' => $request->input('mail_x'),



                'y' => $request->input('mail_y'),



                'color' => $request->input('mail_color'),



            ],



        ];

        $iconRecords = [];

        foreach ($icons as $type => $data) 

        {

            if ($data['icon']) {

                $iconName = time() . '_' . $type . '.' . $data['icon']->getClientOriginalExtension();

                $data['icon']->move(public_path('images/Bottom Bar Assets/Icons'), $iconName);

                // Store icon in the frame_icons table

                $iconRecords[] = Frameicon::create([

                    'frame_id' => $frame->id,

                    'icon_type' => $type,

                    'x' => $data['x'],

                    'y' => $data['y'],

                    'color' => $data['color'],

                    'icon_image' => $iconName,

                ]);

            }

        }

        // Return a JSON response with the created frame and icons

        return response()->json([

            'status' => 'success',

            'message' => 'Frame and icons added successfully',

            'frame' => $frame,

            'icons' => $iconRecords,

        ], 201);

    }

    catch (\Exception $e) 

    {

        return response()->json([

            'status' => 'error',

            'message' => 'An error occurred while processing the request',

            'error' => $e->getMessage(),

        ], 500);

    }

}

public function frame_delete(Request $request)

{



    $request->validate([



        'id' => 'required'



    ]);





     $data = Frame::find($request->id);

     if($data)

     {

        $data->delete();

           return response()->json([



            'status' => 'true',



            'message' => 'Frame and related data deleted successfully',



        ], 200);

     }

   return response()->json([

            'status' => 'false',

            'message' => 'Frame not foudn!!',

        ], 404);

}

public function edit_frame_api(Request $request)

{

    $request->validate([

        'frame_id' => 'required',

    ]);

    $data = Frame::find($request->frame_id);

    if($data)

      {

        $image = $request->file('frame');

        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('images/Bottom Bar Assets'), $imageName);



        $data->frame_path = $imageName;

        $data->save();

          

      }

      return response()->json([

        'status' => 'false',

        'message' => 'No Frame Found',

    ], 404);





}

public function store_frame_excel(Request $request)

{
    $request->validate([
        'excel_file' => 'required|file|mimes:xlsx,csv',
    ]);
    try 
    {
        Excel::import(new FrameImport, $request->file('excel_file'));
        return response()->json([
            'status' => 'true',
            'message' => 'Excel data imported successfully',
        ], 200);
    } catch (\Exception $e) 
    {
        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while importing the Excel data',
            'error' => $e->getMessage(),
        ], 500);
    }

}

public function store_frame_api2(Request $request)

{

 

    $request->validate([

        'frame' => 'required|file|mimes:jpg,jpeg,png',

    ]);

    try 

    {

        // Handle frame this image

        $image = $request->file('frame');

        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('images/Bottom Bar Assets'), $imageName);

        // Store frame in the frames table

        $frame = Frame::create([

            'fram_path' => $imageName,

            'frame_height' => $request->frame_height

        ]);

    $icons = [

        'address' => [

            'icon' => $request->file('address_icon'),

            'x' => $request->input('address_x'),

            'y' => $request->input('address_y'),

            'color' => $request->input('address_color'),

            'size' => $request->input('address_size', null),

            'reverse_icon_value' => $request->input('address_reverse_icon_value', null),

        

        ],

        'mobile' => [

            'icon' => $request->file('mobile_icon'),

            'x' => $request->input('mobile_x'),

            'y' => $request->input('mobile_y'),

            'color' => $request->input('mobile_color'),

            'size' => $request->input('mobile_size', null), 

            'reverse_icon_value' => $request->input('mobile_reverse_icon_value', null),



            

        ],

        'website' => [

            'icon' => $request->file('website_icon'),

            'x' => $request->input('website_x'),

            'y' => $request->input('website_y'),

            'color' => $request->input('website_color'),

            'size' => $request->input('website_size', null),

            'reverse_icon_value' => $request->input('website_reverse_icon_value', null),



        ],

        'email' => [

            'icon' => $request->file('email_icon'),

            'x' => $request->input('email_x'),

            'y' => $request->input('email_y'),

            'color' => $request->input('email_color'),

            'size' => $request->input('email_size', null),

            'reverse_icon_value' => $request->input('email_reverse_icon_value', null),



        ], 

        'company' => [

            'icon' => $request->file('company_icon'),

            'x' => $request->input('company_x'),

            'y' => $request->input('company_y'),

            'color' => $request->input('company_color'),

            'size' => $request->input('company_size', null),

                 'reverse_icon_value' => $request->input('company_reverse_icon_value', null),



        ],

    ];



        $iconRecords = [];

        foreach ($icons as $type => $data) 

        {

            if ($data['icon']) 

            {

                $iconName = time() . '_' . $type . '.' . $data['icon']->getClientOriginalExtension();

                $data['icon']->move(public_path('images/Bottom Bar Assets/Icons'), $iconName);

                $iconRecords[] = Frameicon::create([

                    'frame_id' => $frame->id,

                    'icon_type' => $type,

                    'x' => $data['x'],

                    'y' => $data['y'],

                    'color' => $data['color'],

                    'icon_image' => $iconName,

                    'size' => $data['size'], 

                    'reverse_icon_value' =>$data['reverse_icon_value'],

                ]);

            }

        }

        // Handle FrameRatioApp data

        $elementTypes = ['address', 'mobile', 'website', 'email','company','name']; 

        $frameRatioRecords = [];

        foreach ($elementTypes as $type) 

        {

            $frameRatioRecords[] = FrameRatioApp::create([

                'frame_id' => $frame->id,

                'element_type' => $type,

                'x_left' => $request->input('x_left_' . $type),

                'y_top' => $request->input('y_top_' . $type),

                'font_size' => $request->input('font_size_' . $type),

                'font_color' => $request->input('color_code_' . $type),

                'monst' => $request->input('monst_' . $type),   

                'height' => $request->input('height_' . $type),

                'width' => $request->input('width_' . $type),

                'reverse_value' => $request->input('reverse_value_' . $type),

            ]);

        }

        return 

        

        response()->json([

            'status' => 'true',

            'message' => 'Frame, icons, and FrameRatioApp data added successfully',

            'frame' => $frame,

            'icons' => $iconRecords,

            'frame_ratio_apps' => $frameRatioRecords,

        ], 200);

    } 

    catch (\Exception $e) 

    {

        return response()->json([

            'status' => 'error',

            'message' => 'An error occurred while processing the request',

            'error' => $e->getMessage(),

        ], 500);

    }

}

public function framedisplay_api(Request $request)

{



     $data = Frame::all();



     if($data)

     {



         foreach($data as $item)

         {

           

            $item->fram_path = url("images/Bottom Bar Assets/" . $item->fram_path);

           

         }



        return   response()->json([

        'status' => 'true',

        'message' => 'Frame Displayed successfully',

        'data' => $data,

    

    ], 200);

}





}

public function update_frame_api(Request $request)

{

   

    $request->validate([

        'id' => 'required',

        'frame' => 'nullable|file|mimes:jpg,jpeg,png',

        'address_icon' => 'nullable|file|mimes:jpg,jpeg,png',

        'address_x' => 'nullable|numeric',

        'address_y' => 'nullable|numeric',

        'address_color' => 'nullable|string',

        'mobile_icon' => 'nullable|file|mimes:jpg,jpeg,png',

        'mobile_x' => 'nullable|numeric',

        'mobile_y' => 'nullable|numeric',

        'mobile_color' => 'nullable|string',

        'website_icon' => 'nullable|file|mimes:jpg,jpeg,png',

        'website_x' => 'nullable|numeric',

        'website_y' => 'nullable|numeric',

        'website_color' => 'nullable|string',

        'email_icon' => 'nullable|file|mimes:jpg,jpeg,png',

        'email_x' => 'nullable|numeric',

        'email_y' => 'nullable|numeric',

        'email_color' => 'nullable|string',

    ]);



    try {

        // Fetch the frame

        $frame = Frame::findOrFail($request->id);



        // Update frame image if provided

        if ($request->hasFile('frame')) {

            // Delete old frame image

            if ($frame->fram_path && file_exists(public_path('images/Bottom Bar Assets/' . $frame->fram_path))) {

                unlink(public_path('images/Bottom Bar Assets/' . $frame->fram_path));

            }



            $image = $request->file('frame');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('images/Bottom Bar Assets'), $imageName);



            $frame->fram_path = $imageName;

        }



        // Update other frame attributes if provided

        $frame->frame_height = $request->input('frame_height', $frame->frame_height);

        $frame->save();



        // Update icons

        $icons = [

            'address' => [

                'icon' => $request->file('address_icon'),

                'x' => $request->input('address_x'),

                'y' => $request->input('address_y'),

                'color' => $request->input('address_color'),

                'size' => $request->input('address_size'),

                'reverse_icon_value' => $request->input('address_reverse_icon_value'),

            

            ],

            'mobile' => [

                'icon' => $request->file('mobile_icon'),

                'x' => $request->input('mobile_x'),

                'y' => $request->input('mobile_y'),

                'color' => $request->input('mobile_color'),

                'size' => $request->input('mobile_size'), 

                'reverse_icon_value' => $request->input('mobile_reverse_icon_value'),

    

                

            ],

            'website' => [

                'icon' => $request->file('website_icon'),

                'x' => $request->input('website_x'),

                'y' => $request->input('website_y'),

                'color' => $request->input('website_color'),

                'size' => $request->input('website_size'),

                'reverse_icon_value' => $request->input('website_reverse_icon_value'),

    

            ],

            'email' => [

                'icon' => $request->file('email_icon'),

                'x' => $request->input('email_x'),

                'y' => $request->input('email_y'),

                'color' => $request->input('email_color'),

                'size' => $request->input('email_size'),

                'reverse_icon_value' => $request->input('email_reverse_icon_value'),

    

            ], 

            'company' => [

                'icon' => $request->file('company_icon'),

                'x' => $request->input('company_x'),

                'y' => $request->input('company_y'),

                'color' => $request->input('company_color'),

                'size' => $request->input('company_size'),

                     'reverse_icon_value' => $request->input('company_reverse_icon_value')

    

            ],

        ];



        foreach ($icons as $type => $data) 
        {

            $icon = Frameicon::where('frame_id', $frame->id)->where('icon_type', $type)->first();



            if ($icon) {

                

                if ($data['icon']) {

                    // Delete old icon image

                    if ($icon->icon_image && file_exists(public_path('images/Bottom Bar Assets/Icons/' . $icon->icon_image))) {

                        unlink(public_path('images/Bottom Bar Assets/Icons/' . $icon->icon_image));

                    }



                    $iconName = time() . '_' . $type . '.' . $data['icon']->getClientOriginalExtension();

                    $data['icon']->move(public_path('images/Bottom Bar Assets/Icons'), $iconName);



                    $icon->icon_image = $iconName;

                }

                $icon->x = $data['x'] ?? $icon->x;

                $icon->y = $data['y'] ?? $icon->y;

                $icon->color = $data['color'] ?? $icon->color;

                $icon->size = $data['size'] ?? $icon->size;

                $icon->reverse_icon_value = $data['reverse_icon_value'] ?? $icon->reverse_icon_value;

            

                $icon->save();

            } elseif ($data['icon']) {

                // Create new icon record if icon doesn't exist

                $iconName = time() . '_' . $type . '.' . $data['icon']->getClientOriginalExtension();

                $data['icon']->move(public_path('images/Bottom Bar Assets/Icons'), $iconName);



                Frameicon::create([

                    'frame_id' => $frame->id,

                    'icon_type' => $type,

                    'x' => $data['x'],

                    'y' => $data['y'],

                    'color' => $data['color'],

                    'icon_image' => $iconName,

                    'size' => $data['size'],

                    'reverse_icon_value' =>$data['reverse_icon_value'],

                ]);

            }

        }



        // Update FrameRatioApp data

        $elementTypes = ['address', 'mobile', 'website', 'email', 'company','name'];

        foreach ($elementTypes as $type) {

            $frameRatio = FrameRatioApp::where('frame_id', $frame->id)->where('element_type', $type)->first();



            if ($frameRatio) {

                $frameRatio->x_left = $request->input('x_left_' . $type, $frameRatio->x_left);

                $frameRatio->y_top = $request->input('y_top_' . $type, $frameRatio->y_top);

                $frameRatio->font_size = $request->input('font_size_' . $type, $frameRatio->font_size);

                $frameRatio->font_color = $request->input('color_code_' . $type, $frameRatio->font_color);

                $frameRatio->monst = $request->input('monst_' . $type, $frameRatio->monst);

                $frameRatio->height = $request->input('height_' . $type, $frameRatio->height);

                $frameRatio->width = $request->input('width_' . $type, $frameRatio->width);

                $frameRatio->reverse_value = $request->input('reverse_value_' . $type, $frameRatio->reverse_value);

                $frameRatio->save();

            }

        }



        return response()->json([

            'status' => 'true',

            'message' => 'Frame, icons, and FrameRatioApp data updated successfully',

        ], 200);

    } catch (\Exception $e) {

        // Handle exceptions and return proper error response

        return response()->json([

            'status' => 'error',

            'message' => 'An error occurred while updating the data',

            'error' => $e->getMessage(),

        ], 500);

    }

}   

public function framedisplay(Request $request)

{

        if($request->ajax())

        {

            $columns = array( 

                0 =>'id', 

                1 =>'fram_path',

            );

        $totalData = Frame::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');

        $start = $request->input('start');

        $order = $columns[$request->input('order.0.column')];

        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))

        {            

        $posts = Frame::offset($start)

                    ->limit($limit)

                    ->orderBy($order,$dir)

                    ->get();

        }

        else 

        {

        $search = $request->input('search.value'); 

        $posts =  Frame::where('id','LIKE',"%{$search}%")

                        ->orWhere('fram_path', 'LIKE',"%{$search}%")

                        ->offset($start)

                        ->limit($limit)

                        ->orderBy($order,$dir)

                        ->get();

        $totalFiltered = Frame::where('id','LIKE',"%{$search}%")

                        ->orWhere('fram_path', 'LIKE',"%{$search}%")

                        ->count();

        }

        $data = array();

        if(!empty($posts))

        {

        foreach ($posts as $post)

        {

            $nestedData['id'] = $post->id;

            $nestedData['fram_path'] = $post->fram_path;

            $data[] = $nestedData;

        }

        }

        $json_data = array(

                "draw"            => intval($request->input('draw')),  

                "recordsTotal"    => intval($totalData),  

                "recordsFiltered" => intval($totalFiltered), 

                "data"            => $data   

                );

        return response()->json($json_data);

            }

        return view('admin.framedisplay');

}

public function getCategories(Request $request)

{

        $categories = ImageCategory::all();

          return response()->json($categories);

}

public function deleteimage(Request $request,$id)

{

        $id2 = Image::find($id)->delete();



        if (!empty($id2)) {



            return response()->json([



                'success' => $id, 'Image deleted successfully!',



            ]);



        } else {



            return response()->json([



                'success' => $id, 'id not found!',



            ]);







        }



}

public function deleteframe(Request $request,$id)

{

        $id2 = Frame::find($id)->delete();

        if (!empty($id2)) {

            return response()->json([

                'success' => $id, 'Image deleted successfully!',

            ]);

        }   

         else 

        {

            return response()->json([

                'success' => $id, 'id not found!',

            ]);

        }



}

public function updateimagee(Request $request)

{

    $id = $request->id ;

    $image = Image::find($id);

    $image->name_colour = $request->input('name_colour', $image->name_colour);

    $image->mobile_colour = $request->input('mobile_colour', $image->mobile_colour);

    $image->address_colour = $request->input('address_colour', $image->address_colour);

    $image->email_colour = $request->input('email_colour', $image->email_colour);

    $image->website_colour = $request->input('website_colour', $image->website_colour);

    $image->company_colour = $request->input('company', $image->company_colour);

    $image->address_icon_color = $request->input('address_icon_color', $image->address_icon_color);

    $image->mobile_icon_color = $request->input('mobile_icon_color', $image->mobile_icon_color);

    $image->email_icon_color = $request->input('email_icon_color', $image->email_icon_color);

    $image->web_icon_color = $request->input('web_icon_color', $image->web_icon_color);

    $image->logo_x = $request->input('logo_x', $image->logo_x);

    $image->logo_y = $request->input('logo_y', $image->logo_y);

    $image->logo_allingment = $request->input('logo_allingment', $image->logo_allingment);

    $image->logo_size = $request->input('logo_size', $image->logo_size);

    $image->logo_height = $request->input('logo_height', $image->logo_height);

    $image->logo_width = $request->input('logo_width', $image->logo_width);



    // Save the updated record

    $image->save();



     return redirect()->back();





}

public function editimage($id)

{

    $image = Image::find($id);



    return view('admin.imageedit',compact('image'));

}

public function appparamter($id)

{



    $data = FrameRatioApp::where('frame_id',$id)->get();

    $namedata = FrameRatioApp::where('frame_id', $id)->where('element_type', 'name')->first();

    $emaildata = FrameRatioApp::where('frame_id', $id)->where('element_type', 'email')->first();

    $websitedata = FrameRatioApp::where('frame_id', $id)->where('element_type', 'website')->first();

    $mobiledata = FrameRatioApp::where('frame_id', $id)->where('element_type', 'mobile')->first();

    $addressdata = FrameRatioApp::where('frame_id', $id)->where('element_type', 'address')->first();

    $companydata = FrameRatioApp::where('frame_id', $id)->where('element_type', 'company')->first();





    return view('admin.appparamter', compact('id', 'data','namedata', 'emaildata', 'websitedata', 'mobiledata', 'addressdata', 'companydata'));



}

public function storeappparameter(Request $request)   

{

    $frameId = $request->input('id');

    $elementTypes = ['name', 'email', 'website', 'mobile', 'address', 'company'];

    foreach ($elementTypes as $type) {



        $existingData = FrameRatioApp::where('frame_id', $frameId)



                                     ->where('element_type', $type)



                                     ->first();



        



        if ($existingData) {



            // Update existing data



            $existingData->x_left = $request->input('x_left_' . $type);



            $existingData->y_top = $request->input('y_left_' . $type);



            $existingData->font_size = $request->input('font_size_' . $type);



            $existingData->font_color = $request->input('color_code_' . $type);



            $existingData->monst = $request->input('monst_' . $type);



            $existingData->letter = $request->input('letter_' . $type);



            $existingData->height = $request->input('height_' . $type);



            $existingData->width = $request->input('width_' . $type);





            $existingData->save();



        } else {



            // Create new entry



            FrameRatioApp::create([



                'frame_id' => $frameId,



                'element_type' => $type,



                'x_left' => $request->input('x_left_' . $type),



                'y_top' => $request->input('y_left_' . $type),



                'font_size' => $request->input('font_size_' . $type),



                'font_color' => $request->input('color_code_' . $type),



                'monst' => $request->input('monst_' . $type),



                'letter' => $request->input('letter_' . $type),

                'height' => $request->input('height_' . $type),

                'width' => $request->input('width_' . $type),



            ]);



        }



    }







    







    session::flash('code','success');











    return redirect()->route('frame')->with('success', 'Parameters saved successfully.');







      



     



}

public function editframe($id)

{



         $data = Frame::find($id);

         return view('admin.frameedit',compact('data'));



}

public function updateframe(Request $request,$id)

{

        $data = Frame::find($id);  

        if($request->has('image'))

        {

            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('images/Bottom Bar Assets'), $imageName);

        }



          $data->fram_path  = $imageName;

          $data->save();

          session::flash('code','success');



          return redirect()->route('frame')->with('success', 'Frame updated Successfully.');

}



}



