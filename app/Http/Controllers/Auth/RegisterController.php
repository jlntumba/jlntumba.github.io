<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
            'name' => ['required', 'string', 'max:25'],
            'postnom' => ['required','string','max:25'],
            'prenom' => ['required','string','max:25'],
            'sexe' => ['required','string','max:1'],
            'tel' => ['required','numeric','unique:users,tel,except,id'],
            'code' =>['unique:users,code,except,id'],
            'email' => ['required', 'string', 'email', 'max:255','unique:users,email,except,id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $code = Str::random(8);
        $email = $data['email'];

        return User::create([
            'name' => $data['name'],
            'postnom' => $data['postnom'],
            'prenom' => $data['prenom'],
            'sexe' => $data['sexe'],
            'tel' => $data['tel'],
            'code'=>$code,
            'email' => $email,
            'password' => Hash::make($data['password']),
        ]);
    }
}
