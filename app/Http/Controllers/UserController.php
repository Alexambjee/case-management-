<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

use Illuminate\Support\Carbon;
use Symfony\Contracts\Service\Attribute\Required;

class UserController extends Controller
{
    //Getting all users without condition
    public function getAllUsers()
    {
        // return IroUser::get();
        $usersDetails = DB::table('iro_user_role')
            ->whereIn('ROLE_NAME', ['Admin'])
            ->join('iro_user_mst', 'iro_user_role.id', '=', 'iro_user_mst.ROLE_ID')
            ->select('iro_user_role.ROLE_NAME', 'iro_user_mst.*')
            ->get();
        return $usersDetails;
    }
    public function getAllUsersWithout()
    {
        $usersDetails = DB::table('sxt_role_mst')
            ->whereNotIn('role_name', ['Super', 'admin'])
            ->join('sxt_user_mst', 'sxt_role_mst.role_id', '=', 'sxt_user_mst.role_id')
            ->leftJoin('sxt_departments_mst', function ($join) {
                $join->on('sxt_departments_mst.department_id', '=', 'sxt_user_mst.onDepartment')
                    ->where('sxt_user_mst.onDepartment', '<>', 0);
            })
            ->select('sxt_role_mst.role_desc', 'sxt_departments_mst.department_name', 'sxt_user_mst.*')
            ->get();
        return $usersDetails;
    }

    //to create new user 
    public function getUserInfo(Request $request)
    {
        $name = $request->userName;
        $userInfo = DB::connection('oracle')
            ->table('EDW_HR_DATA')
            ->select('*')
            ->where('USER_NAME', $name)
            ->get();
        \Log::info($userInfo);
        if ($userInfo->count() == 0) {
            return response()->json([
                'msg' => 'Username submitted does not exist!'
            ], 401);
        } else {
            return $userInfo;
        }


    }
    //Getting user details with condition
    public function getUserInfoWhere(Request $request)
    {
        // Replace these with your actual API endpoint and credentials
        $apiEndpoint = 'http://erp01-dev.dc01.kra.go.ke:8000/zstaffexit/staffexit?' . http_build_query([
            'pernr' => $request->userName,
            'sap-client' => 210,
        ]);
        $username = 'ICMS';
        $password = 'Narok.2020';

        $client = new Client();

        try {
            $response = $client->get($apiEndpoint, [
                'auth' => [$username, $password]
            ]);

            if ($response->getStatusCode() == 200) {
                // API call was successful
                $data = $response->getBody()->getContents();
                return response()->json(json_decode($data));
            } else {
                // Handle other response codes if needed
                return response()->json([
                    'error' => 'API call failed',
                    'status_code' => $response->getStatusCode()
                ], 500);
            }
        } catch (\Exception $e) {
            // Handle any exceptions that may occur during the API call
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    //Creating user
    public function createUser(Request $request)
    {

        $action = 'Creating User';
        $clientIp = $request->ip();
        $username = $request->createdBy;
        $domainName = 'T' . $request->nationalId;
        $status = 1;
        $user = DB::table('sxt_user_mst')->where('user_name', $request->userName)->get();
        if ($user->count() > 0) {
            return response()->json([
                'msg' => 'A user with that Username already exists!'
            ], 401);
        } else {
            $audit = DB::table('sxt_audit_mst')->insert([
                'action' => $action,
                'created_by' => $username,
                'client_ip' => $clientIp,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            if ($audit) {
                return DB::table('sxt_user_mst')->insert([
                    'user_name' => $request->userName,
                    'role_id' => $request->roleId,
                    'last_name' => $request->firstName,
                    'other_names' => $request->otherNames,
                    'email_address' => $request->email,
                    'id_number' => $request->nationalId,
                    'status' => $status,
                    'status_reason' => 'ACTIVE',
                    'station_id' => 0,
                    'sec_role' => 0,
                    'created_by' => $request->createdBy,
                    'onDepartment' => $request->onDepartment,
                    'USER_ID' => $domainName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            } else {
                return response()->json([
                    'msg' => 'Something went wrong!'
                ]);
            }

        }


    }
    //Deactivating / activating user account
    public function activateDeactivateUser(Request $request)
    {

        $action = 'User Activation/Deactivation';
        $clientIp = $request->ip();
        $username = $request->createdBy;
        $audit = DB::table('sxt_audit_mst')->insert([
            'action' => $action,
            'created_by' => $username,
            'client_ip' => $clientIp,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        if ($audit) {
            return DB::table('sxt_user_mst')
                ->where('user_id', $request->id)
                ->update(['status_reason' => $request->reason, 'status' => $request->action, 'updated_at' => Carbon::now()]);
        }
    }

    public function getUserDept(Request $request)
    {
        $id = request()->input('id');
        return DB::table('sxt_departments_mst')
            ->where('department_id', $id)
            ->first();
    }
    //Changing user role
    public function changeUserRole(Request $request)
    {
        $action = 'User Role Change';
        $clientIp = $request->ip();
        $username = $request->createdBy;
        $audit = DB::table('sxt_audit_mst')->insert([
            'action' => $action,
            'created_by' => $username,
            'client_ip' => $clientIp,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        if ($audit) {
            $x = DB::table('sxt_user_mst')
                ->where('user_name', $request->userName);
            if ($request->onDepartment) {
                return $x->update(['role_id' => $request->roleId, 'onDepartment' => $request->onDepartment, 'department_id' => $request->onDepartment, 'updated_at' => Carbon::now()]);
            } else {
                return $x->update(['role_id' => $request->roleId, 'updated_at' => Carbon::now()]);
            }


        }
    }
}