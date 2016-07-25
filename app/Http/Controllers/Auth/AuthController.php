<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\auth\RegisterRequest;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\ForgetPasswordRequest;
use App\Http\Requests\auth\ChangePasswordRequest;
use Laracasts\Flash\Flash;

use Illuminate\Contracts\Auth\Guard;

use App\user as w_user;

use Auth;
use Response;
use App\Country;
use Lang;
use App;
use App\Language;
use Request as V_Request;
use App\Setting;
use Config;
use Mail;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    private $maxLoginAttempts = 5;
    protected $redirectPath = '/Lang::getLocale()/admin';
    protected $redirectTo = '/Lang::getLocale()/admin';
    protected $loginPath = '/Lang::getLocale()/admin/login';

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }
    /**
     * Overide Defualt Mail settings.
     *
     * @return Response
     */
    public function mail_setting()
    {
        // config of mail
        $setting = Setting::find(1);
        $data = json_decode($setting->options);
        Config::set('mail.driver', $data->driver);
        Config::set('mail.host', $data->host);
        Config::set('mail.port', $data->port);
        Config::set('mail.from.address', $data->address);
        Config::set('mail.from.name', $data->name);
        Config::set('mail.encryption', $data->encryption);
        Config::set('mail.username', $data->user_name);
        Config::set('mail.password', $data->password);
        //end config of mail
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
        /**
     * Show the application registration form.
     *
     * @return Response
     */
    public function getRegister()
    {
        return view('auth.register');
    }
 
    /**
     * Show the application login form.
     *
     * @return Response
     */
    public function getadmin()
    {
        return view('backend.users.admin_login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  LoginRequest  $request
     * @return Response
     */
    public function postadmin(LoginRequest $request)
    {
        // $email = $request->input('email');
        // $password = $request->input('password');
        // if (Auth::attempt(['email' => $email, 'password' => $password, 'active' =>'1', 'confirmed' => '1']))
        // {
        //     return redirect('admin'); //TODO return redirect('/admin/home');
        // }
        // else{
        //     return redirect('admin/login')->withErrors([
        //         'email' => 'The credentials you entered did not match our records. Try again?',
        //     ]);
        // }
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }
        //Edit Mahmoud Eid make sure user is active
      //  $credentials = $this->getCredentials($request);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'confirmed' => 1,
            'active' => 1
        ];


        if (Auth::attempt($credentials, $request->has('remember'))) {
            $this->handleUserWasAuthenticated($request, $throttles);
            $lang = Lang::getLocale();
            return redirect(''.$lang.'/admin');
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect('admin/login')
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Show the application login form.
     *
     * @return Response
     */
    public function getLogin()
    {
        $countries = Country::all();
        session(['lang' => App::getLocale()]);
        return view('frontend.user.login', compact('countries'));
    }
 
    /**
     * Handle a login request to the application.
     *
     * @param  LoginRequest  $request
     * @return Response
     */
    public function postLogin(LoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $lang = $request->session()->get('lang');
        if (Auth::attempt(['email' => $email, 'password' => $password, 'confirmed' => '1', 'active' => '1']))
        {
            return redirect('/'.$lang.''); //TODO return redirect('/home');
        }
        else{
            return redirect('/'.$lang.'/login')->withInput()->withErrors([
                'email' => 'The credentials you entered did not match our records. Try again?',
            ]);
        }
    }
    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterRequest  $request
     * @return Response
     */
    public function postRegister(RegisterRequest $request)
    {
        $code = rand();
        $country = Country::find($request->country_id);
        $phone_code = $country->code;

        $phone_with_code = $phone_code.$request->input('phone');
        
        //manual validator for phone
        $check_user = User::where('phone', '=', $phone_with_code)->first();
        if($check_user){
            return back()->withErrors(trans('translation.duplicate_phone'))->withInput();
        }
        //end manual validator of phone

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->phone = $phone_code.$request->input('phone');
        if(!empty($request->input('country_id'))) {
             $user->country_id = $request->input('country_id');
         }
        if(!empty($request->input('city_id'))) {
                    $user->city_id = $request->input('city_id');
        }
        if(!empty($request->input('area_id'))) {
                     $user->area_id = $request->input('area_id');
        }
        $user->confirmation_code = $code;
        $user->role = '1';
        $user->save();

        $this->mail_setting();
        $lang = $request->session()->get('lang');
        try {
            Mail::send('emails.active_user', ['user' => $user, 'lang' => $lang], function ($msg) use($user) {
                $msg->from('customer-service@net-electronic.com', 'Net Electronic');
                $msg->to($user->email);
                $msg->subject(trans('translation.active_subject'));
            });
        } catch (\Exception $e) {
            Flash::error(trans('translation.problem_send_email'));
            return back();
        }

        Flash::success(trans('translation.email_sent'));
        return redirect('/'.$lang.'');
    }
    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterRequest  $request
     * @return Response
     */
    public function Active_user($code)
    {
        $user = User::where('confirmation_code', '=', $code)->first();
        if($user) {
           $user->confirmed = '1';
           $user->confirmation_code ='';
           $user->active = '1';
           $user->save();
            return redirect('/'.Lang::getLocale().'/login')->with('status', trans('translation.active_account_message'));
        }else{
            Flash::info("'.trans('translation.active_account_faild').'");
            return back();
        }
    }

    /**
     * Show the application login form.
     *
     * @return Response
     */
    public function get_forget_password()
    {
        session(['lang' => App::getLocale()]);
        return view('frontend.user.forget_password');
    }
    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterRequest  $request
     * @return Response
     */
    public function post_forget_password(ForgetPasswordRequest $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if($user){
            //confrimation code
            $user->confirmation_code = rand();
            $user->save();
            //end confirmation code
            $this->mail_setting();
            $lang = $request->session()->get('lang');
            try {
                Mail::send('emails.forget_password', ['user' => $user, 'lang' => $lang], function ($msg) use($user) {
                    $msg->from('customer-service@net-electronic.com', 'Net Electronic');
                    $msg->to($user->email);
                    $msg->subject(trans('translation.forget_password_subject'));
                });
            } catch (\Exception $e) {
                Flash::error(trans('translation.problem_send_email'));
                return back();
            }
        }
        else{
            Flash::error(trans('translation.email_not_registered'));
            return back();
        }

        Flash::success(trans('translation.password_email_sent'));
        return redirect('/'.$lang.'');
    }
    /**
     * Show the application login form.
     *
     * @return Response
     */
    public function get_change_password($id, $confirmation_code)
    {
        session(['lang' => App::getLocale()]);
        $user = User::where('id', '=', $id)->where('confirmation_code', '=', $confirmation_code)->first();
        if(empty($user)){
            Flash::error(trans('translation.wrong_url'));
            return redirect('/'.Lang::getLocale().'');
        }
        return view('frontend.user.change_password', compact('id', 'confirmation_code'));
    }
    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterRequest  $request
     * @return Response
     */
    public function post_change_password(ChangePasswordRequest $request, $id, $confirmation_code)
    {
        $user = User::where('id', '=', $id)->where('confirmation_code', '=', $confirmation_code)->first();
        $user->password = bcrypt($request->input('password'));
        $user->confirmation_code = '';
        $user->save();

        $lang = $request->session()->get('lang');
        Flash::success(trans('translation.password_changed'));
        return redirect('/'.$lang.'/login');
    }
 
    /**
     * Log the user out of the application.
     *
     * @return Response
     */
    public function getLogout()
    {
        Auth::logout();
 
        return redirect('/'.Lang::getLocale().'')->withErrors([
                'User' => 'This user has been logged out',
            ]);
    }
    /**
     * Log the user out of the application.
     *
     * @return Response
     */
    public function getFailedLoginMessage()
    {
        $message = 'البيانات التي أدخلتها غير متطابقة, أو قد تكون غير مفعل.';
 
        return $message;
    }
    /**
     * Log the user out of the application.
     *
     * @return Response
     */
    public function getLockoutErrorMessage($seconds)
    {
        $message = 'العديد من محاولات الدخول. يرجى المحاولة مرة أخرى في '.$seconds.' ثواني.';
        return $message;
    }
}
