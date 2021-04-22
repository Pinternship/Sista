<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Progdi;
use App\Models\Faculty;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if (str_contains($user->email,'@student.unika.ac.id')) {
                if($finduser){

                    Auth::login($finduser);

                    return redirect('/dashboard');

                }else{
                    // Unika Sista data
                    $nim_raw = explode("@", $user->email);
                    $code_progdi = substr($nim_raw[0], 2, -4);
                    $progdi = Progdi::select('*')->where('code', '=', $code_progdi)->first();

                    // Split nim for Api
                    $codetahun = substr($nim_raw[0], 0, -6);
                    $codenim = substr($nim_raw[0], 4);
                    $nim = $codetahun.".".strtoupper($code_progdi).".".$codenim;

                    $newUser = User::create([
                        'name'              => $user->name,
                        'nim'               => $nim,
                        'progdi'            => $progdi->nama_progdi,
                        'faculty'           => $progdi->faculty,
                        'photo'             => $user->avatar,
                        'email'             => $user->email,
                        'google_id'         => $user->id,
                        'email_verified_at' => now(),
                        'password'          => Hash::make('ilham211')
                    ]);

                    Auth::login($newUser);

                    return redirect('/dashboard');
                }
            }
            else{
                return redirect(route('login'))->with('error', __('app.access_restricted_login'));
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
