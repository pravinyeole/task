<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => 'required|digits:10',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $request = request();

        if($request->hasFile('image'))
        {
            $profileImage = $request->file('image');
            $profileImageSaveAsName = time() . "-profile." . $profileImage->getClientOriginalExtension();

            $upload_path = 'image/';
            $profile_image_url = $upload_path . $profileImageSaveAsName;
            $success = $profileImage->move($upload_path, $profileImageSaveAsName);
            $res['image'] = $profile_image_url;
        }

        $res['first_name'] = $data['first_name'];
        $res['middle_name'] = $data['middle_name'];
        $res['last_name'] = $data['last_name'];
        $res['phone'] = $data['phone'];
        $res['phone_optional'] = $data['phone_optional'];
        $res['email'] = $data['email'];
        $res['password'] = Hash::make($data['password']);
        $this->testmail($res['email']);
         User::create($res);
        return redirect($this->redirectPath())->with('message', 'Plese verify Your account');
    }

    public function testmail($email = null){

        $name = 'verify mail';
        $html_data = '<a href="http://localhost/task/public/verify_user/'.$email.'" target="_blank" class="btn btn-primary">CLick Here To Verify Your account</a>';
        $subject = 'Verify Your account';
        $data = array();
        $name = "Aniket Tandale";
        $subject = "Password Reset Link";

        Mail::send([], [], function ($message)use ($email,$name,$subject,$html_data) {
            $message->to($email,$name)
            ->subject($subject)
            ->setBody($html_data, 'text/html')
            ->setfrom('nmmc@cdaat.in','Test Account');
        });
    }

    public function verify_user($email = null)
    {
        User::where('email',$email)->update(['is_verified'=>1]);
        return redirect('login')->with('success','Account verify sucessfully');
    }   
}
