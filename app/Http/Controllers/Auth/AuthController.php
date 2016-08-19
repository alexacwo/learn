<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

use Auth;

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

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
   // protected $redirectTo = '/tasks';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
            'password' => 'required|min:6|confirmed',
        ]);
    }


    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
 
     /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
	 * @param  App\User  $user
     */
	 
     public function authenticated($request, $user)
    {		
		if ($user->role === 'admin') {
			return redirect('/admin');
		} 
		
        return redirect('/');
    }

    /**
     * Display a list of all of the user's task.
     *
     * @return Response
     */
    public function showLoginForm()
    {
		$client_id = '5596102'; // ID приложения
		$client_secret = 'GUJSAeIRvqza01D2Woot'; // Защищённый ключ
		$redirect_uri = 'http://localhost/step/laravel/learn/public/register'; // Адрес для редиректа после авторизации

		$url = 'http://oauth.vk.com/authorize';

		$params = array(
			'client_id'     => $client_id,
			'redirect_uri'  => $redirect_uri,
			'response_type' => 'code',
			'scope' => 'email'
		);
		
		$link = $url . '?' . urldecode(http_build_query($params));
			
        return view('auth.login', [
            'link' => $link
        ]);
    }
	
	
	
    /**
     * Show the application registration form.
     *
	 * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRegister(Request  $request)
    {		
		$client_id = '5596102'; // ID приложения
		$client_secret = 'GUJSAeIRvqza01D2Woot'; // Защищённый ключ
		$redirect_uri = 'http://localhost/step/laravel/learn/public/register'; // Адрес для редиректа после авторизации
		
		$token = '';
		$email = '';	
		$uid = '';
		$first_name = '';
		$screen_name = '';
		$sex = '';
		$bdate = '';
		$photo_big = '';	
		
		if (null !== $request->get('code')) {
			$result = false;
			$params = array(
				'client_id' => $client_id,
				'client_secret' => $client_secret,
				'code' => $request->get('code'),
				'redirect_uri' => $redirect_uri
			);

			$token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
			
			if (isset($token['email'])) {
				$email = $token['email'];
			}
	
			if (isset($token['access_token'])) {
				$params = array(
					'uids'         => $token['user_id'],
					'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
					'access_token' => $token['access_token']
				);

				$userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
				
				if (isset($userInfo['response'][0]['uid'])) {
					$userInfo = $userInfo['response'][0];
					$result = true;
				}
			}

			if ($result) {
				$uid = $userInfo['uid'];
				$first_name = $userInfo['first_name'];
				$screen_name = $userInfo['screen_name'];
				$sex = $userInfo['sex'];
				$bdate = $userInfo['bdate'];
				$photo_big = $userInfo['photo_big'];
			}
			
		/*	return view('auth.register', [
				'token' => json_encode($token),
				'email' => $email,
				'uid' => $uid,
				'first_name' => $first_name,
				'screen_name' => $screen_name,
				'sex' => $sex,
				'bdate' => $bdate,
				'photo_big' => $photo_big
			]);*/			
			
			$vk_credentials = array(
				"name" => $first_name,
				"email" => $email,
				"password" => null				
			);
			
			$x = Auth::attempt(array('email' => $email, 'password' => '$2y$10$KKS5OR8LrJszcVtbOAr9ROd9dtWxHIWunqN/jFvG.zPDCKb12.xHO'));
			var_dump($x);
			
			if (Auth::attempt(['email' => $email, 'password' => null])) {
				// Authentication passed...
				 return redirect()->intended('/');
			}  else {
				\Auth::guard($this->getGuard())->login($this->create($vk_credentials));
			} 
			
			//return redirect($this->redirectPath());
		}	
		
		return view('auth.register', [
			'token' => '',
			'email' => '',
			'uid' => '',
			'first_name' => '',
			'screen_name' => '',
			'sex' => '',
			'bdate' => '',
			'photo_big' => ''
		]);
    }
	 
}
