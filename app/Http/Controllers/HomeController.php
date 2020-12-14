<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware(['auth','is_verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = User::where('created_by',Auth::id())->get();
        $other_user = User::where('created_by',null)->where('email','!=',Auth::user()->email)->get();

        return view('home',compact('data','other_user'));
    }

    protected function contact_reg(Request $request)
    {
        $request = request();
        $this->validate($request,array(
            
            'first_name' => 'required', 'string', 'max:255',
            'last_name' => 'required', 'string', 'max:255',
            'phone' => 'required|digits:10',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users'
        ));

        if($request->hasFile('image'))
        {
            $profileImage = $request->file('image');
            $profileImageSaveAsName = time() . "-profile." . $profileImage->getClientOriginalExtension();

            $upload_path = 'image/';
            $profile_image_url = $upload_path . $profileImageSaveAsName;
            $success = $profileImage->move($upload_path, $profileImageSaveAsName);
            $data['image'] = $profile_image_url;
        }
        
        
        $data['first_name'] = $request->first_name;
        $data['middle_name'] = $request->middle_name;
        $data['last_name'] = $request->last_name;
        $data['phone'] = $request->phone;
        $data['phone_optional'] = $request->phone_optional;
        $data['email'] = $request->email;
        $data['created_by'] = Auth::id();
        $data['modified_by'] = Auth::id();
        if(isset($request->old_id))
        {
            User::where('id',$request->old_id)->update($data);
            $msg = 'Contact form updated successfully.';
        }
        else
        {
            User::create($data);
            $msg = 'Contact form created successfully.';
        }
        return redirect('/home')->back()->with('success', $msg); 
    }

    public function share_deatils(Request $request)
    {
        User::where('id',$request->share_user_id)->update(['modified_by'=>$request->id]);
        return ["status"=>true,"msg"=>"Contact Share successfully"];
    }

    public function edit(Request $request,$id=null)
    {
        $data = User::where('id',$id)->first();
        return view('edit',compact('data'));
    }
}
