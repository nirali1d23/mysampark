<?php

namespace App\Http\Controllers;

use App\Models\PersonalCategory;
use App\Models\personal_category_image;
use App\Models\personal_category_list;
use Illuminate\Http\Request;
use Session;
use Validator;

class PersonalCategoryController extends Controller
{
    public function personalcategory(Request $request)
    {
        if ($request->ajax()) {
            $columns = array(
                0 => 'id',
                1 => 'name',
            );
            $totalData = PersonalCategory::count();
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) 
            {
                $posts = PersonalCategory::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } 
            else 
            {
                $search = $request->input('search.value');

                $posts = PersonalCategory::where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered = PersonalCategory::where('id', 'LIKE', "%{$search}%")
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
                "recordsFiltered" => isset($totalFiltered) ? intval($totalFiltered) : intval($totalData),
                "data" => $data,
            );
            return response()->json($json_data);
        }
        return view('admin.personalcategory');
    }
    public function personalcategoryadd()
    {
        return view('admin.personalcategoryadd');
    }
    public function personalimagestore(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), 
        [
            "pname" => "required|min:2",
            "name" => "required",
            "image.*" => "required|image|mimes:jpeg,png,jpg,gif|max:2048", // Adjust validation rules as needed
        ]);
        if ($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $pc = new PersonalCategory();
        $pc->name = $request->input("pname");
        $pc->save();
        $vehicle = new personal_category_list();
        $vehicle->name = $request->input("name");
        $vehicle->personal_category_id = $pc->id;
        if ($request->hasFile('cat_images')) 
        {
            foreach ($request->file('cat_images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
            }
            $vehicle->category_image = $filename;
        }
        $vehicle->save();
        if ($request->hasFile("images")) 
        {
            foreach ($request->file("images") as $index => $uploadedFile) {
                $originalFileName = time() . "_" . uniqid() . "." . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(public_path("images"), $originalFileName);

                $vehicleModel = new personal_category_image();
                $vehicleModel->image = $originalFileName;

                $vehicleModel->personal_category_list_id = $vehicle->id;
                $vehicleModel->save();
            }
        }
        session::flash("code", "success");
        return redirect()->route('imagecategory');
    }
    public function personaledit($id)
    {
        $personal_category_image = personal_category_image::where("personal_category_list_id", $id)->get();
        $personal_category_list = personal_category_list::where('personal_category_id', $id)->get();
        $personal_category_list = personal_category_list::find($id);

        $PersonalCategory = PersonalCategory::find($id);
        return view("admin.personalcategoryedit", compact('PersonalCategory', 'personal_category_list', 'personal_category_image'));
    }
    public function test()
    {
        
        return view("admin.test");
    }
    public function peronallist($id)
    {
        return view("admin.personalcategory_list");
    }
    public function peronallistdata(Request $request, $id)
    {
        if ($request->ajax()) {
            $columns = [
                0 => "id",
                1 => "name",
                2 => "category_image",

            ];
            $totalData = personal_category_list::count();
            $totalFiltered = $totalData;
            $limit = $request->input("length");
            $start = $request->input("start");
            $order = $columns[$request->input("order.0.column")];
            $dir = $request->input("order.0.dir");
            if (empty($request->input("search.value"))) {
                $posts = personal_category_list::where("personal_category_id", $id)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input("search.value");

                $posts = personal_category_list::where("personal_category_id", $id)
                    ->where("id", "LIKE", "%{$search}%")
                    ->orWhere("name", "LIKE", "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered = personal_category_list::where("personal_category_id", $id)
                    ->where("id", "LIKE", "%{$search}%")
                    ->orWhere("name", "LIKE", "%{$search}%")
                    ->count();
            }

            $data = array();
            if (!empty($posts)) {
                foreach ($posts as $post) {
                    $nestedData['id'] = $post->id;
                    $nestedData['name'] = $post->name;
                    $nestedData['category_image'] = $post->category_image;
                    $data[] = $nestedData;
                }
            }
            $json_data = [
                "draw" => intval($request->input("draw")),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $data,
            ];

            return response()->json($json_data);
        }

        return view("admin.personalcategory_list" . compact("id"));
    }
    public function personalimage()
    {
        return view('admin.personal_image');
    }
    public function personal_image_store(request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [

            "image.*" => "required|image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $image_id = $request->id;
        if ($request->hasFile("images")) {
            foreach ($request->file("images") as $index => $uploadedFile) {
                $originalFileName = time() . "_" . uniqid() . "." . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(public_path("images"), $originalFileName);

                $vehicleModel = new personal_category_image();
                $vehicleModel->image = $originalFileName;

                $vehicleModel->personal_category_list_id = $image_id;
                $vehicleModel->save();
            }
        }

        Session::flash("code", "success");
        return redirect()->route('personalcategory');

    }
    public function addpersonalcategory(request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $product = new PersonalCategory();
        $product->name = $request->input('name');
        $product->save();

        session::flash('code', 'success');

        return redirect('personalcategory')->with('status', 'category Added successfully');
    }
    public function personal_data(request $request)
    {
        // Validate the request data
        $validator = validator::make($request->all(), [
            'name' => 'required',
            'personal_category_id' => 'required', 
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        
        $product = new personal_category_list();
        $product->name = $request->input('name');
        $product->personal_category_id = $request->input('personal_category_id'); 
        if ($request->hasFile('image')) {
            $filename = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images'), $filename);
            $product->category_image = $filename;
        }
        $product->save();
        session::flash('code', 'success');
        return redirect('category')->with('status', 'Category added successfully');
    }
    public function store_personal_image(Request $request, $id) {
        $personal_category = personal_category_list::find($id); 
    
        return view('admin.personal_image_add', compact('personal_category'));
    }
    public function personal_image_storedata(Request $request,$id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            "name" => "required|min:2",
            "image.*" => "required|image|mimes:jpeg,png,jpg,gif|max:2048", // Adjust validation rules as needed

        ]);
        $personal_id=$request->id;

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $vehicle = new personal_category_list();
        $vehicle->name = $request->input("name");
        $vehicle->personal_category_id = $personal_id;


        if ($request->hasFile('cat_images')) {
            foreach ($request->file('cat_images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
            }
            $vehicle->category_image = $filename;
        }

        $vehicle->save();

        if ($request->hasFile("images")) {
            foreach ($request->file("images") as $index => $uploadedFile) {
                $originalFileName = time() . "_" . uniqid() . "." . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(public_path("images"), $originalFileName);

                $vehicleModel = new personal_category_image();
                $vehicleModel->image = $originalFileName;

                $vehicleModel->personal_category_list_id  = $vehicle->id;
                $vehicleModel->save();
            }
        }

        Session::flash("code", "success");
        return redirect()->route('imagecategory');
    }
    
}
