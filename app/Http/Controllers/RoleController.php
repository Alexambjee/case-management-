<?php

namespace App\Http\Controllers;

use App\Models\iroRole;
use App\Models\iroAuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

class RoleController extends Controller
{
    //fetching all roles
    public function fetchRoles() {
        return DB::table('sxt_role_mst')->select('*')->whereNotIn('role_name',['Admin'])
                    ->get();
    }
    public function fetchRolesWithout() {
        return iroRole::whereNotIn('ROLE_NAME',['Super'])->get();
    }
    //store roles
    public function store(Request $request) {
        $this->validate($request,[
            'ROLE_NAME'=>'bail|required|unique:App\Models\iroRole',
            'roleDesc'=>'required',
        ]);
        $action ='Creating role';       
        $clientIp = $request->ip();
        $username =$request->username;   
            $audit =iroAuditTrail::create([
                    'ACTION'=>$action,
                    'CREATED_BY'=>$username,
                    'CLIENT_IP'=>$clientIp
                ]);
                if($audit){
                    return iroRole::create([
                        'ROLE_NAME' =>$request->ROLE_NAME,
                        'ROLE_DESC' =>$request->roleDesc,
                        'CREATED_BY'=> $request-> username
                    ]);
                }
                else{
                    return response()->json([
                        'msg'=>'Something went wrong'
                    ]);
                    
                }
                
       
    }
    public function updateRole(Request $request) {
       $this->validate($request,[
            'ROLE_NAME'=>'bail|required|unique:App\Models\iroRole',
            'roleDesc'=>'required',
            'id'=>'required',
        ]); 
        $action ='Updating role';      
        $clientIp = $request->ip();
        $username =$request->username;

        $audit =iroAuditTrail::create([
            'ACTION'=>$action,
            'CREATED_BY'=>$username,
            'CLIENT_IP'=>$clientIp
        ]);
            if ($audit) {
                return iroRole::where('id',$request->id)->update([
                    'ROLE_NAME' =>$request->ROLE_NAME,
                    'ROLE_DESC' =>$request->roleDesc,
                ]);
            }
    }
}