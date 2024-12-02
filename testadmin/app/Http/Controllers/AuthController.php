<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Validator;

use Hash;

use App\Models\User;

use App\Models\Business;

use App\Models\Image;
use App\Models\Frame;

class AuthController extends Controller

{ 

    public function login()
    {
        return view('Auth.login');
    }

    public function loginn(Request $request)
    {
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:8'

        );



        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return Redirect::to('/')

                ->withErrors($validator)

                ->withInput($request->all());

        } else {

            $userdata = array(

                'email' => $request->get('email'),

                'password' => $request->get('password'));

            if (Auth::attempt($userdata)) 

            {

                return redirect()->route('dashbord');

            } 

            else 

            {

                

                return redirect()->route('/')->withErrors('Invalid email or password');

            }

        }

    }
    public function logout()
    {

        Auth::logout();

        return redirect('/')->with('status', 'You have been logged out.');

    }
    public function login_api(Request $request)
   {
         $validator = Validator::make($request->all(), [

        'email' => 'required|email',
        'password' => 'required|min:6',

                ]);


    // Check if validation fails
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Validation failed',
                        'errors' => $validator->errors(),
                    ], 400);
                }
    // Check if credentials are valid

                 $user = User::where('email', $request->email)->first();

                if ($user && \Hash::check($request->password, $user->password)) 
                {
                    $token = $user->createToken('auth_token')->plainTextToken;


        // If credentials are valid, generate a token (optional)



        return response()->json([

            'status' => 'true',

            'message' => 'Login successful',

            'user' => $user,

            'token' => $token,

           // You can send this token for authenticated requests

        ], 200);

    } else {

        // If credentials are invalid

        return response()->json([

            'status' => 'error',

            'message' => 'Invalid email or password',

        ], 401);

    }

    }
    public function dashbord_api(Request $request)
    {

        $user = User::count();

        $bussiness=Business::count();

        $image=Image::count();

        $frame = Frame::count();

        return response()->json([
            'status' => 'true',
            'message' => 'dashbord displayed',
            'user_total' =>$user,
            'bussiness_total' =>$bussiness,
            'image_total' =>$image,
            'frame_total' =>$frame
        ], 200);
    }
    public function dashbord()
    {

         $user = User::count();

          $bussiness=Business::count();

          $image=Image::count();

        return view('admin.dashbord',compact('user','bussiness','image'));

    }
    public function userlist(Request $request)
    {

        if($request->ajax())

        {

            $columns = array( 

                0 =>'id', 

                1 =>'image',

        

            );

        $totalData = User::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');

        $start = $request->input('start');

        $order = $columns[$request->input('order.0.column')];

        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))

        {            

        $posts = User::offset($start)

                    ->limit($limit)

                    ->where('user_type' , '!=' , 3)

                    ->orWhereNull('user_type')

                    ->orderBy($order,$dir)

                    ->get();

        }

        else 

        {

        $search = $request->input('search.value');

        $posts =  User::where('id','LIKE',"%{$search}%")

                        ->orWhere('image', 'LIKE',"%{$search}%")

                        ->offset($start)

                        ->limit($limit)

                        ->orderBy($order,$dir)

                        ->get();

        $totalFiltered = User::where('id','LIKE',"%{$search}%")

                        ->orWhere('image', 'LIKE',"%{$search}%")

                        ->count();

        }

        $data = array();

        if(!empty($posts))

        {

        foreach ($posts as $post)

        {

            $nestedData['id'] = $post->id;

            $nestedData['name'] = $post->name;

            $nestedData['email'] = $post->email;

            $nestedData['mobileno'] = $post->mobileno;

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

        return view('admin.userlist');

    }
    public function userlist_api(Request $request)
    {
         $data = User::where('user_type' , '!=' , 3)->get();
         return response()->json([
            'status' => 'true',
            'message' => 'user displayed',
            'data' =>$data,
           
        ], 200);

    }
    public function userdetails_api(Request $request)
    {
        $user = User::with('businesses')->with('personal')->find($request->id);
         if($user)
         {
            return response()->json([
                'status' => 'true',
                'message' => 'user displayed',
                'data' =>$user,
               
            ], 200);
         }

         return response()->json([
            'status' => 'false',
            'message' => 'No User found',
            'data' =>$user,
           
        ], 200);
    }
    public function useredit_api(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'mobileno' => 'required'
            ]);
    
        $user = User::find($request->id);
        if($user)
        {
           $user->name = $request->name;
           $user->email = $request->email;
           $user->mobileno = $request->mobileno;
           $user->save();
        }
        return response()->json([
            'status' => 'false',
            'message' => 'No User found',
            'data' =>$user,
           
        ], 200);
    }
    public function viewuser(Request $request,$id)
    {
        $user = User::with('businesses')->with('personal')->find($id);
        return view('admin.userview',compact('user')); 
    }
    public function edituser(Request $request,$id)
    {
        $data = User::find($id);
        return view('admin.useredit',compact('data'));
    }
    public function updateuser(Request $request)
    {
        $user = User::find($request->id);
        if($user)
        {
             $user->name = $request->name;
             $user->mobileno = $request->mobileno;
             $user->email = $request->email;
             $user->save();
             return redirect('/userlist')->with('status', 'User updated successfully.');
        }
    }

}