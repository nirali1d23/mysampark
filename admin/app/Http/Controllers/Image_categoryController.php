<?php



namespace App\Http\Controllers;



use App\Models\Bussiness_Image;

use App\Models\Image;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Session;



class Image_categoryController extends Controller

{

   public function display_image_category(Request $request)
   {
     $data = Bussiness_Image::all();

     return response()->json([
        'status' => 'true',
        'data' => $data,
        'message' => 'Category Displayed !!',
    ], 200);

   }
   public function imagecategory_delete(Request $request)
   {
        $request->validate([

            'id' => 'required',
        ]);
         $data = Bussiness_Image::find($request->id);
         if($data)
         {

            $images = Image::where('category_id',$request->id)->get();

             foreach($images as $image)
             {
                 $image->delete();
             }
              $data->delete();
              return response()->json([
                'status' => 'true',
                'message' => 'Category Deleted !!',
            ], 200);

         }
         return response()->json([
            'status' => 'false',
            'message' => 'category Not found !!',

        ], 200);

           
   }

   public function imagecategory_api(Request $request)
    {

                $request->validate([

                'name' => 'required',

                'type' => 'required'

            ]);


          $product = new Bussiness_Image();
        $product->name = $request->input('name');
        $product->type = $request->input('type');
        if($request->has('date'))

        {

        $product->date = $request->input('date');

        }

        $product->save();
          return response()->json([
            'status' => 'true',
            'data' =>$product,
            'message' => 'category created !!',
        ], 200);
     




    }

    public function imagecategory(request $request)
    {

        if ($request->ajax()) {

            $columns = array(

                0 => 'id',

                1 => 'name',

            );



            $totalData = Bussiness_Image::count();



            $totalFiltered = $totalData;



            $limit = $request->input('length');

            $start = $request->input('start');

            $order = $columns[$request->input('order.0.column')];

            $dir = $request->input('order.0.dir');



            if (empty($request->input('search.value'))) {

                $posts = Bussiness_Image::offset($start)

                    ->limit($limit)

                    ->orderBy($order, $dir)

                    ->get();

            } else {

                $search = $request->input('search.value');



                $posts = Bussiness_Image::where('id', 'LIKE', "%{$search}%")

                    ->orWhere('name', 'LIKE', "%{$search}%")

                    ->offset($start)

                    ->limit($limit)

                    ->orderBy($order, $dir)

                    ->get();



                $totalFiltered = Bussiness_Image::where('id', 'LIKE', "%{$search}%")

                    ->orWhere('name', 'LIKE', "%{$search}%")

                    ->count();

            }



            $data = array();

            if (!empty($posts)) {

                foreach ($posts as $post) {

                    $nestedData['id'] = $post->id;

                    $nestedData['name'] = $post->name;

                    $data[] = $nestedData;

                }

            }

            $json_data = array(

                "draw" => intval($request->input('draw')),

                "recordsTotal" => intval($totalData),

                "recordsFiltered" => intval($totalFiltered),

                "data" => $data,

            );



            return response()->json($json_data);



        }



        return view('admin.image_category');

    }

    public function deleteiamgecategory($id)

    {



    

          $image = Image::where('category_id',$id)->get();



          if ($image->isNotEmpty()) {

      

            foreach ($image as $images) {

                if ($images) 

                { 

                    $images->delete();

                }

              

        }



        $id2 = Bussiness_Image::find($id)->delete();

        if (!empty($id2)) {

            return response()->json([

                'success' => $id, 'Record deleted successfully!',

            ]);

        } else {

            return response()->json([

                'success' => $id, 'id not found!',

            ]);



        }

    }

}

    public function store(Request $request)

    {

        $validator = validator::make($request->all(), [

            'name' => 'required',

        ]);



        if ($validator->fails()) {

            return redirect()->back()

                ->withErrors($validator)

                ->withInput();

        }

        $product = new Bussiness_Image();

        $product->name = $request->input('name');

        $product->save();



        session::flash('code', 'success');



        return redirect('imagecategory')->with('status', 'category Added successfully');



    }

     public function update_image_category(Request $request)
     {

        
        $request->validate([

            'image_category_id' => 'required',
            'name' => 'required',

            'type' => 'required'

        ]);

      $product = Bussiness_Image:: find($request->image_category_id);
      if($product)
     {

     
    $product->name = $request->input('name');
    $product->type = $request->input('type');
    if($request->has('date'))

    {

    $product->date = $request->input('date');

    }


    $product->save();
      return response()->json([
        'status' => 'true',
        'data' =>$product,
        'message' => 'category created !!',
    ], 200);
 
     }

     return response()->json([
        'status' => 'false',
        'message' => 'category Not Found !!',
    ], 200);

     }
    public function imagestoree()

    {

        return view('admin.imagecategorycreate');

    }

    public function imagestore(Request $request)

    {

        // dd($request->all());

        $validator = Validator::make($request->all(), [

            "name" => "required|min:2",

            "image.*" => "required|image|mimes:jpeg,png,jpg,gif|max:2048", // Adjust validation rules as needed



        ]);



        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }

        $vehicle = new Bussiness_Image();

        $vehicle->name = $request->input("name");



        if ($request->hasFile('cat_images')) {

            foreach ($request->file('cat_images') as $file) {

                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('images'), $filename);

            }

            $vehicle->image = $filename;

        }



        $vehicle->save();



        if ($request->hasFile("images")) {

            foreach ($request->file("images") as $index => $uploadedFile) {

                $originalFileName = time() . "_" . uniqid() . "." . $uploadedFile->getClientOriginalExtension();

                $uploadedFile->move(public_path("images"), $originalFileName);



                $vehicleModel = new Image();

                $vehicleModel->image = $originalFileName;



                $vehicleModel->category_id = $vehicle->id;

                $vehicleModel->save();

            }

        }



        Session::flash("code", "success");

        return redirect()->route('imagecategory');

    }



    public function edit($id)

    {

        $displayimage = Image::where("category_id", $id)->get();

        $image = Bussiness_Image::find($id);

        return view("admin.image_edit", compact('image', 'displayimage'));

    }




    public function updateimage(Request $request, $id)

    {

        $validator = Validator::make($request->all(), [

            "name" => "required",

        ]);



        if ($validator->fails()) {

            return redirect()

                ->back()

                ->withErrors($validator)

                ->withInput();

        }



        $vehicle = Bussiness_Image::find($id);



        if ($vehicle) {

            $vehicle->name = $request->input("name");



            if ($request->hasFile("cat_images")) {

                $bannerImage = $request->file("cat_images");

                $bannerImageFilename =

                time() .

                "_" .

                rand(1000, 5000000) .

                "." .

                $bannerImage->getClientOriginalExtension();

                $bannerImage->move(public_path("images"), $bannerImageFilename);

                $vehicle->image = $bannerImageFilename;

            }



            $vehicle->update();



            if ($request->hasFile("image")) {



                Image::where("category_id", $id)->delete();



                foreach ($request->file("image") as $model) {

                    $imagePath = time() . "_" . uniqid() . "." . $model->getClientOriginalName();

                    $model->move(public_path("images"), $imagePath);



                    $vehicleImage = new Image();

                    $vehicleImage->image = $imagePath;

                    $vehicleImage->category_id = $id;

                    $vehicleImage->save();

                }

            }

            Session::flash("code", "success");



            return redirect()->route('imagecategory');

        } else {



            return redirect()->back()->withErrors([' not found.']);

        }

    }



}

