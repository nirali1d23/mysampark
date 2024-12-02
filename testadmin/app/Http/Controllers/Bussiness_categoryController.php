<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Bussiness_category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class Bussiness_categoryController extends Controller
{
    public function category(request $request){
        if($request->ajax()){
            $columns = array( 
                0 =>'id', 
                1 =>'name',
                2 =>'icon',
            );

        $totalData = Bussiness_category::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
        $posts = Bussiness_category::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
        }
        else {
        $search = $request->input('search.value'); 

        $posts =  Bussiness_category::where('id','LIKE',"%{$search}%")
                        ->orWhere('name', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

        $totalFiltered = Bussiness_category::where('id','LIKE',"%{$search}%")
                        ->orWhere('name', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if(!empty($posts))
        {
        foreach ($posts as $post)
        {
            $nestedData['id'] = $post->id;
            $nestedData['name'] = $post->name;
            $nestedData['icon'] = $post->image;
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
        return view('admin.category');
    }

    public function delete(request $request,$id)
    {
       
        $bussinessCategory = Bussiness_category::find($id);

        if ($bussinessCategory) {
           
            $relatedImages = Image::where('category_id', $id)->count();

            if ($relatedImages == 0) {
             
                $bussinessCategory->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Record deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete category with associated images!'
                ]);
            }
        } else
        {
            return response()->json([
                'success' => false,
                'message' => 'ID not found!'
            ]);
 
    }
}

    
    public function storebuss(Request $request)
    {          
        // dd($request->all());
        $validator = validator::make($request->all(), [
            'name'=> 'required',
        ]);
      
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
           

                    $product = new Bussiness_category();
                    $product->name = $request->input('name');
                    if ($request->hasFile('image')) {

                        $filename = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                    
                        $request->file('image')->move(public_path('images'), $filename);
                        $product->image = $filename;
                    }

                    $product->save();
                
                    session::flash('code','success');

        return redirect('category')->with('status','category Added successfully');
   
}
}
