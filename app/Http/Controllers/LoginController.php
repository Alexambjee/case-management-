<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
// use Illuminate\Contracts\Session\Session;
use Symfony\Component\HttpFoundation\Session\Session;
//exit();
class LoginController extends Controller
{
    // protecting routes
    public function Index(Request $request){
        return view('home');
    }
    // login function
    public function Login(Request $request ){
        // validate
        $this->validate($request,[
            'username' => 'bail|required|min:9',
            'password' => 'bail|required|'
        ]);

        $ldap_password = $request->password;
        $ldap_username = $request->username.'@kra.gov';
        $ldapconfig['host'] = '10.180.1.14';
        $ldapconfig['port'] = '389';
        $ldap_connection = ldap_connect($ldapconfig['host'], $ldapconfig['port']);
        $userFind = null;
        try{
            // user exists
            ldap_bind($ldap_connection, $ldap_username, $ldap_password);

            \Log::info($request->username);
            try{
                // try finding the user with the USER_ID or USER_NAME
                $userFind = DB::table('sxt_user_mst')
                    ->where('USER_ID', $request->username)
                    ->orWhere('user_name', $request->username)
                    ->first();
                // bail if the user is not found
                if (!$userFind) {
                    return response()->json([
                        'msg' => 'User not found'
                    ], 404);
                }
                // if the user is found, update their password with a hased one
                $hashedPassword = bcrypt($request->password);
                DB::table('sxt_user_mst')
                    ->where('USER_ID', $request->username)
                    ->orWhere('user_name', $request->username)
                    ->update(['password' => $hashedPassword]);
            }

            catch (\Exception $e) {
                \Log::info($e);
                return response()->json([
                    'msg'=>`Something went wrong,$e`
                ],401);
            }

         }
         catch (\Exception $e) {
            \Log::info($e);
            return response()->json([
                'msg'=>'Invalid Credentials'
            ],401);
        }
        $authTry = Auth::attempt(['USER_ID' => $request->username, 'password' => $request->password]);
        if (!$authTry) {
            // if USER_ID fails, try auth with USER_NAME
            $authTry = Auth::attempt(['user_name' => $request->username, 'password' => $request->password]);
        }

        // bail if the credentials are invalid after two attempts
        if (!$authTry) {
            return response()->json([
                'msg' => 'Invalid Credentials'
            ], 401);
        }

        $user = Auth::user();
        
        // check or create a login trail
        $loginTrail = DB::table('sxt_login_trail')->where('USER_NAME', $user->user_name)
            ->where('STATUS', 1)
            ->first();
        \Log::info($user);
        $role = $user->role;
        //   if ($loginTrail->STATUS == 1) {
        //     // session_destroy();
        //     // Auth::logout();
        //     // return response()->json([
        //     //    'msg' => 'Access Denied. Your account has been logged
        //     //            in somewhere else kindly logout first then try again!',
        //     // ], 401);
        // } else 
        if ($loginTrail) {
            DB::table('sxt_login_trail')->where('USER_NAME', $user->user_name)->update(
                [
                    'STATUS' => 1,
                    'LOGIN_TIME' => now(),
                    'LOCAL_IP' => $request->ip()
                ]
            );
        } else {
            DB::table('sxt_login_trail')->insert(
                [
                    'USER_NAME' => $user->user_name,
                    'SESSION_ID' => null,
                    'STATUS' => 1,
                    'LOGIN_TIME' => now(),
                    'LOCAL_IP' => $request->ip()
                ]
            );
        }

    // check if user is active
    if($user->status != 1){
        session_destroy();
        Auth::logout();
        return response()->json([
            'msg'=>'Access Denied!Your Account is Inactive,  Kindly Contact your Administrator.'
        ],401);
    } else{
      
        // start the session
        session_start();
        $_SESSION['session'] = $user;
        $role = $user->role_id;

        $roledata = DB::table('sxt_role_mst')
            ->where('role_id', $role)
            ->first();
        $lowercaseRole = str_replace('_', '-', strtolower($role));

            return response()->json([
                'msg'=>"Hi, $user->last_name, Welcome back.",
                'user'=>$user,
                'role'=>$roledata,
            ]);
        }
}

public function Logout(Request $request){
        // return 'hello';
        // return $request->Cookie();
        Cookie::forget('PHPSESSID');
        Cookie::forget('XSRF-TOKEN');
        Cookie::forget('iroinsight_session');
       
            // unset($_COOKIE['XSRF-TOKEN']); 
            // unset($_COOKIE['iroinsight_session']);
            // unset($_COOKIE['PHPSESSID']);
            // setcookie('session', null, -1, '/'); 
            
       
        // terminate session using user ip address

        DB::table('sxt_login_trail')->where('LOCAL_IP',$request->ip())
                    ->where('STATUS',1)
                    ->update([
                    'LOGOUT_TIME'=>now(),
                    'STATUS'=>0
                ]);
        return redirect('/');
    }
}