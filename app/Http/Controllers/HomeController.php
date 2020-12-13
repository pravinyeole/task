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
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
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
         User::create($data);
        return back()->with('success', 'Contact form created successfully.'); 
    }
}
