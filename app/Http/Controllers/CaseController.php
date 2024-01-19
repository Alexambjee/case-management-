<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\MailAlert;
use App\Models\SxtCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\UniqueNumController;
use App\Http\Controllers\SystemManagerController;

class CaseController extends Controller
{
    public function CaseCreation($request, $type)
    {

        \Log::info(json_encode($request));

        $objUniqueNum = new UniqueNumController();
        $caseNo = $objUniqueNum->generateUniqueNum('0123456789', 6, true);
        $year = Date('Y');
        $status = 0;
        $clientIp = $request->ip;
        $username = $request->username;

        if ($type == 'Auto') {
            $caseNum = 'S' . $caseNo . '-' . $year . '-A';
            $caseSource = 'I-support';
            $action = 'Creating Automatic case';

        } else {
            $caseNum = 'S' . $caseNo . '-' . $year . '-M';
            $caseSource = 'Manual';
            $action = 'Creating manual case';

        }


        $exitstatus = 0;
        if ($request->exit_date) {
            $currentDate = Carbon::now()->toDateString();
            $exitDate = Carbon::parse($request->exit_date)->toDateString();
            if ($currentDate == $exitDate) {
                $exitstatus = 1;
            }
        }

        $audit = DB::table('sxt_audit_mst')->insert([
            'action' => $action,
            'created_by' => $username,
            'client_ip' => $clientIp,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        if ($audit) {

            $remarks = DB::table('sxt_remarks_mst')->insert([
                'case_id' => $caseNum,
                'username' => $username,
                'type' => 'initiator',
                'remarks' => $request->remarks,
                'created_at' => Carbon::now()->format('Y-m-d'),
                'updated_at' => Carbon::now()->format('Y-m-d')
            ]);


            $insertComplete = DB::table('sxt_case_mst')->insert([
                'case_id' => $caseNum,
                'user_name' => $request->p_no,
                'station' => $request->station,
                'employee_name' => $request->staff_name,
                'address' => $request->address,
                'designations' => $request->designation,
                'department' => $request->dept_id,
                'division' => $request->div_id,
                'join_date' => $request->app_date,
                'exit_date' => $request->exit_date,
                'phone' => $request->phone,
                'email' => $request->mail,
                'status' => $status,
                'created_at' => Carbon::now(),
                // departments
                'library' => $exitstatus,
                'knowledge_capture' => $exitstatus,
                'facilities_assets' => $exitstatus,
                'facilities_housing' => $exitstatus,
                'ICT_Asset' => $exitstatus,
                'ICT_ACCOUNT1' => $exitstatus,
                'ICT_ACCOUNT2' => $exitstatus,
                'ICT_ACCOUNT3' => $exitstatus,
                'ICT_ACCOUNT4' => 0,
                'ICT_VPN' => $exitstatus,
                'training' => $exitstatus,
                'medical' => $exitstatus,
                'security' => $exitstatus,
                'payroll' => 0,
                'own_department' => $exitstatus
            ]);

            if ($insertComplete) {
                $insertedData = DB::table('sxt_case_mst')->where('case_id', $caseNum)->first();

                if ($exitstatus == 1) {
                    DB::table('sxt_case_mst')->where('case_id', $caseNum)->update(['case_exit_status' => 1]);
                    $sender = DB::table('sxt_user_mst')
                        ->where('user_name', $request->username)->first();
                    $emaildata = [
                        'message' => "Request clearance for $request->staff_name personal number $request->p_no,Issued by $sender->other_names
                        Log in to the StaffExit tool (KRAHUB insightcmt) to clear the case.
                        ",
                        'username' => $sender->other_names
                    ];
                    $this->sendAlerts($caseNum, $emaildata);
                    return $insertedData;
                } else {
                    DB::table('sxt_case_mst')->where('case_id', $caseNum)->update(['case_exit_status' => 0]);
                }

            }
        }
    }

    #########function create manual case begins#########
    public function createManualCase(Request $request)
    {
        #\Log::info($request->all());
        $this->CaseCreation($request, 'Manu');
    }
    // date handle
    public function dateformat($dateStringx)
    {

        if ($dateStringx != '0000-00-00') {
            $dateString = Carbon::createFromFormat('Y-m-d', $dateStringx);
            $dateCarbon = Carbon::parse($dateString);
            $x = $dateCarbon->toDateString();
            return $x;
        } else {
            return null;
        }

    }

    function departmentId($departmentName, $departments)
    {
        $filteredDepartments = array_values(array_filter($departments, function ($dept) use ($departmentName) {
            return $dept->department_name === $departmentName;
        }));

        if (!empty($filteredDepartments)) {
            return $filteredDepartments[0]->department_id;
        }

        return null;
    }

    function divisionId($divisionName, $divisions)
    {
        $filteredDivisions = array_values(array_filter($divisions, function ($div) use ($divisionName) {
            return $div->division_name === $divisionName;
        }));

        if (!empty($filteredDivisions)) {
            return $filteredDivisions[0]->division_id;
        }

        return null;
    }

    function designationId($designationName, $designations)
    {
        $filteredDesignations = array_values(array_filter($designations, function ($desig) use ($designationName) {
            return $desig->designation_name === $designationName;
        }));

        if (!empty($filteredDesignations)) {
            return $filteredDesignations[0]->designation_id;
        }

        return null;
    }

    #########function create Automatic case begins#########
    public function createAutoCase(Request $request)
    {
        $header = $request->header('Authorization');
        $f = explode(' ', $header)[1];
        $username = env('API_USERNAME');
        $password = env('API_PASSWORD');
        $Auth = "$username:$password";
        $g = base64_encode($Auth);
        if ($f != $g) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $departmentsax = $this->getDept($request);
        $designationax = $this->getDesig($request);
        $x = new SystemManagerController();
        $divisionsax = $x->getAllDivisions($request);
        $designationa = $designationax->toArray();

        $divisionsa = $divisionsax->toArray();
        $departmentsa = $departmentsax->toArray();


        $mappedData = (object) [
            'exit_date' => $request->EXIT_DATE !== null ? $this->dateformat($request->EXIT_DATE) : Carbon::now(),
            'app_date' => $request->APPOINTMENT_DATE !== null ? $this->dateformat($request->APPOINTMENT_DATE) : Carbon::now(),
            'div_id' => $this->divisionId($request->DIVISION, $divisionsa) ,
            'dept_id' => $this->departmentId($request->DEPARTMENT, $departmentsa),
            'designation' => $this->designationId($request->DESIGNATION, $designationa),
            'p_no' => $request->PERNR !== null ? $request->PERNR : '12227',
            'station' => $request->STATION_NAME,
            'staff_name' => $request->FIRST_NAME . " " . $request->LAST_NAME,
            'address' => $request->REGION_NAME,
            'phone' => $request->TEL_NUMBER,
            'remarks' => 'Auto Cases from I support',
            'contract' => $request->CONTRACT_TYPE,
            'username' => 'K00012227',
            'mail' => $request->EMAIL,
            'ip' => $request->ip(),
        ];

        $this->CaseCreation($mappedData, 'Auto');

    }
    #########function create manual case ends#########
    #########function get stations begins##############
    public function getStations(Request $request)
    {
        $stations = DB::table('sxt_station_mst')->select('id', 'STATION_NAME')->orderBy('STATION_NAME', 'ASC')->get();
        return $stations;
    }
    #########function get stations ends##############
    #########function sendAlerts begins##############
    public function sendAlerts($case_id, $emailData)
    {


        $getusers = DB::table('sxt_user_mst')
            ->where('status', 1)
            ->leftjoin('sxt_role_mst', 'sxt_user_mst.role_id', '=', 'sxt_role_mst.role_id')
            ->select('*')->get();

        foreach ($getusers as $user) {
            // if($user->role_desc == "own_department")
            $Cot = DB::table('sxt_case_mst')
                ->where('case_id', $case_id);
            if ($user->role_desc != 'hr' && $user->role_desc != 'admin' && $user->role_desc != 'payroll') {
                Mail::to($user->email_address)->send(new MailAlert($emailData));
                //$Cot->update([$user->role_desc => 1]);
                $updated = true;
            }
        }
        return $getusers;
    } #########function get stations ends##############

    #######======Report Functions begins=====#######
    // =========== fetching admin for All Cases Report ===============
    // =========== fetching Completed Cases Reports ===============
    public function fetchCompletedCases(Request $request)
    {
        $reportCompleted = SxtCase::join('status_mst', 'iro_case_mst.STATUS', '=', 'status_mst.STATUS_ID')
            ->whereIn('STATUS', [-4, 9, 5, 6])
            ->get();
        return $reportCompleted;
    }
    // =========== fetching Cases In Progress Reports ===============
    public function fetchInProgress(Request $request)
    {
        $reportInProgress = SxtCase::join('status_mst', 'iro_case_mst.STATUS', '=', 'status_mst.STATUS_ID')
            ->whereIn('STATUS', [1, 2, 3, -3, 4, 8, 7])
            ->get();
        return $reportInProgress;
    }

    public function getAdminProgress(Request $request)
    {
        $admin = DB::table('sxt_case_mst')
            ->whereIn('status', [0, 1])
            ->leftJoin('sxt_departments_mst', 'sxt_departments_mst.department_id', '=', 'sxt_case_mst.department')
            ->leftJoin('sxt_division_mst', 'sxt_division_mst.division_id', '=', 'sxt_case_mst.division')
            ->leftJoin('sxt_designations_mst', 'sxt_designations_mst.designation_id', '=', 'sxt_case_mst.designations')
            ->select('sxt_case_mst.*', 'sxt_departments_mst.department_name', 'sxt_division_mst.division_name', 'sxt_designations_mst.designation_name')
            ->get();
        return $admin;

    }
    public function fetchReportData(Request $request)
    {
        $allCases = DB::connection('pgsql')->table('sxt_case_mst')
            ->get();
        $countAllCases = $allCases->count();

        $underReview = DB::connection('pgsql')->table('sxt_case_mst')
            ->whereIn('status', [3])
            ->get();
        $countunderReview = $underReview->count();

        $processingInDept = DB::connection('pgsql')->table('sxt_case_mst')
            ->whereIn('status', [4])
            ->get();

        $countprocessingInDept = $processingInDept->count();

        $reportNotStarted = DB::connection('pgsql')->table('sxt_case_mst')
            ->whereIn('status', [0])
            ->get();

        $countNotStarted = $reportNotStarted->count();

        $reportInDepartmentLevel = DB::connection('pgsql')->table('sxt_case_mst')
            ->whereIn('status', [1])
            ->get();

        $countProgressInDepartmentLevel = $reportInDepartmentLevel->count();

        $completed = DB::connection('pgsql')->table('sxt_case_mst')
            ->whereIn('status', [2])
            ->get();
        $count_completed = $completed->count();

        $reportSeriesData = array($countNotStarted, ($countProgressInDepartmentLevel + $countprocessingInDept + $countunderReview), $countunderReview, $count_completed, );
        return $reportSeriesData;
    }

    public function fetchReportDataDept(Request $request)
    {

        $underReview = DB::connection('pgsql')->table('sxt_case_mst')
            ->whereIn($request->dept, [3])
            ->get();
        $countunderReview = $underReview->count();


        $tasks = DB::connection('pgsql')->table('sxt_case_mst')
            ->whereIn($request->dept, [1])
            ->get();
        $counttasks = $tasks->count();


        $completed = DB::connection('pgsql')->table('sxt_case_mst')
            ->whereIn($request->dept, [2])
            ->get();
        $count_completed = $completed->count();

        $reportSeriesData = array($counttasks, $countunderReview, $count_completed);
        return $reportSeriesData;
    }


    // =========== fetching reverted Cases Reports ===============
    public function revertedCases(Request $request)
    {
        $reportsReverted = SxtCase::join('status_mst', 'iro_case_mst.STATUS', '=', 'status_mst.STATUS_ID')
            ->whereIn('STATUS', [-1, -2])
            ->get();
        return $reportsReverted;
    }


    #########function get all cases begins##########
    public function getAllCases(Request $request)
    {
        return DB::table('sxt_case_mst')->select('*')->orderBy('created_at', 'DESC')->get();
    }


    public function getDept(Request $request)
    {
        return DB::connection('pgsql')
            ->table('sxt_departments_mst')
            ->select('*')->get();
    }
    public function getDiv(Request $request)
    {
        $id = request()->input('id');
        return DB::connection('pgsql')->table('sxt_division_mst')
            ->where('department_id', $id)
            ->select('*')
            ->get();
    }
    public function getDesig(Request $request)
    {
        return DB::connection('pgsql')->table('sxt_designations_mst')
            ->select('*')
            ->get();
    }

    public function reportData(Request $request)
    {
        $data = explode(',', $request->data);

        $username = $data[0];
        $date = $data[1];
        $formattedDate = $date . '%';

        $status = explode(',', $data[2]);
        ;
        $data = DB::connection('pgsql')->table('sxt_remarks_mst')
            ->select('*')
            ->distinct("sxt_remarks_mst.case_id")
            ->join('sxt_case_mst', 'sxt_remarks_mst.case_id', '=', 'sxt_case_mst.case_id')
            ->where('sxt_remarks_mst.username', $username)
            ->where('sxt_case_mst.created_at', 'LIKE', $formattedDate . '%')
            ->whereIn('sxt_case_mst.status', $status)
            ->leftjoin('sxt_status_info', 'sxt_case_mst.status', '=', 'sxt_status_info.status_id')
            ->get();
        $total = $data->count();
        //T36434201         //K00012227 T37318479
        return [$data, $total];

    }
    // fetching cases
    public function getCases(Request $request)
    {
        $search_1 = request()->input('query');
        $search_1 = strtolower($search_1);

        $current_page = request()->input('page');
        $hr_role = request()->input('role');

        $items_per_page = 10;
        $skip = ($current_page - 1) * $items_per_page;


        if ($hr_role == 'hr') {
            $status = explode(',', $request->data);
            $status = array_map('intval', $status);


            $get_cases = DB::connection('pgsql')->table('sxt_case_mst')
                ->whereIn('status', $status)
                ->where(function ($query) use ($search_1) {
                    $query->orWhere(DB::raw('LOWER(user_name)'), 'like', '%' . $search_1 . '%')
                        ->orWhere(DB::raw('LOWER(employee_name)'), 'like', '%' . $search_1 . '%')
                        ->orWhere(DB::raw('LOWER(email)'), 'like', '%' . $search_1 . '%')
                        ->orWhere(DB::raw('LOWER(phone)'), 'like', '%' . $search_1 . '%')
                        ->orWhere(DB::raw('LOWER(case_id)'), 'like', '%' . $search_1 . '%');
                });
            // ->orderBy('sxt_case_mst.created_at', 'ASC')
            $total = $get_cases->count();
            $cases = $get_cases->leftjoin('sxt_status_info', 'sxt_case_mst.status', '=', 'sxt_status_info.status_id')
                ->skip($skip)->take($items_per_page)
                ->get();



            return [$cases, $total];

        }
        if ($hr_role == 'admin') {
            $status = explode(',', $request->data);
            $status = array_map('intval', $status);


            $get_cases = DB::connection('pgsql')->table('sxt_case_mst')
                ->whereIn('status', $status)
                ->where(function ($query) use ($search_1) {
                    $query->orWhere(DB::raw('LOWER(user_name)'), 'like', '%' . $search_1 . '%')
                        ->orWhere(DB::raw('LOWER(employee_name)'), 'like', '%' . $search_1 . '%')
                        ->orWhere(DB::raw('LOWER(email)'), 'like', '%' . $search_1 . '%')
                        ->orWhere(DB::raw('LOWER(phone)'), 'like', '%' . $search_1 . '%')
                        ->orWhere(DB::raw('LOWER(case_id)'), 'like', '%' . $search_1 . '%');
                });
            // ->orderBy('sxt_case_mst.created_at', 'ASC')
            $total = $get_cases->count();
            $cases = $get_cases->leftjoin('sxt_status_info', 'sxt_case_mst.status', '=', 'sxt_status_info.status_id')
                ->skip($skip)->take($items_per_page)
                ->get();



            return [$cases, $total];

        } else {
            $data = explode(',', $request->data);
            $status = $data[0];
            $role = $data[1];
            $role_desc = $data[2] ?? null;
            $get_cases = DB::connection('pgsql')->table('sxt_case_mst')
                ->whereColumn($role_desc, '=', DB::raw($status))
                ->where(function ($query) use ($search_1) {
                    $query->orWhere(DB::raw('LOWER(user_name)'), 'like', '%' . $search_1 . '%')
                        ->orWhere(DB::raw('LOWER(employee_name)'), 'like', '%' . $search_1 . '%')
                        ->orWhere(DB::raw('LOWER(email)'), 'like', '%' . $search_1 . '%')
                        ->orWhere(DB::raw('LOWER(phone)'), 'like', '%' . $search_1 . '%')
                        ->orWhere(DB::raw('LOWER(case_id)'), 'like', '%' . $search_1 . '%');
                });
            $total = $get_cases->count();
            $cases = $get_cases->leftjoin('sxt_status_info', $role_desc, '=', 'sxt_status_info.status_id')
                ->skip($skip)->take($items_per_page)
                ->get();



            return [$cases, $total];
        }

    }

    // fetching single case details
    public function fetchDetails(Request $request)
    {
        // FETCHING A SINGLE CASE DETAIL
        return DB::connection('pgsql')->table('sxt_case_mst')->where('case_id', $request->caseId)
            ->leftjoin('sxt_status_info', 'sxt_case_mst.status', '=', 'sxt_status_info.status_id')
            ->leftjoin('sxt_departments_mst', 'sxt_case_mst.department', '=', 'sxt_departments_mst.department_id')
            ->leftjoin('sxt_designations_mst', 'sxt_case_mst.designations', '=', 'sxt_designations_mst.designation_id')
            ->leftjoin('sxt_division_mst', 'sxt_case_mst.division', '=', 'sxt_division_mst.division_id')
            ->first();


    }
    public function get_liabilities(Request $request)
    {
        $data = explode(',', $request->data);
        $caseId = $data[0];
        $department = $data[1];
        return DB::connection('pgsql')
            ->table('sxt_liabilities_mst')
            ->where('case_id', $caseId)
            ->where('dept_id', $department)
            ->get();


    }


    //Liability stufff
    public function updateLib(Request $request)
    {
        try {

            foreach ($request->all()[2] as $liability) {
                DB::table('sxt_liabilities_mst')
                    ->where('liab_id', $liability['liab_id'])
                    ->update([
                        'cleared' => 1,
                        'cleared_by' => $request->all()[0],
                        'dept_cleared' => $request->all()[1],
                        'comment' => $liability['comment'],
                        'updated_at' => Carbon::now()->format('Y-m-d')
                    ]);


                if (isset($liability['filenames']) && is_array($liability['filenames'])) {
                    $datafile = (object) ['filename' => $liability['filenames']];
                    foreach ($datafile->filename as $filename) {
                        $filePath = '/uploads/' . $filename;
                        $attStatus = 0;
                        DB::table('sxt_attachment_mst')->insert([
                            'attachment_name' => $filename,
                            'attachment_link' => $filePath,
                            'case_id' => $liability['liab_id'],
                            'attachment_status' => $attStatus,
                            'created_at' => Carbon::now()->format('Y-m-d'),
                            'updated_at' => Carbon::now()->format('Y-m-d')
                        ]);


                    }
                }
            }
        } catch (\Exception $e) {
            \Log::info($e);
            return response()->json(['error' => 'Server Error'], 500);
        }
    }


    public function updateCase(Request $request)
    {

        try {
            DB::beginTransaction();
            $action = "Departmental Clearance";
            $clientIp = $request->ip();

            DB::table('sxt_audit_mst')->insert([
                'action' => $action,
                'created_by' => $request->username,
                'client_ip' => $clientIp,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $yx = DB::table('sxt_remarks_mst')
                ->where('case_id', $request->caseId)
                ->where('depart_id', $request->lib_dept_id)->first();
            if (!$yx) {
                DB::table('sxt_remarks_mst')->insert([
                    'remarks' => $request->Remarks ?? $request->remarks,
                    'type' => $request->Recommendation,
                    'username' => $request->username,
                    'department_id_' => $request->department,
                    'depart_id' => $request->lib_dept_id,
                    'case_id' => $request->caseId,
                    'updated_at' => Carbon::now()->format('Y-m-d')

                ]);
            }

            $status = $request->Recommendation == "yes_lib" ? 3 : 2;


            if ($request->Choice == "monetary") {
                DB::table('sxt_liabilities_mst')->insert([
                    'case_id' => $request->caseId,
                    'username' => $request->username,
                    'product_name' => $request->Lib_item,
                    'dept_id' => $request->department,
                    'amount' => $request->Amount,
                    'cleared' => 0,
                    'created_at' => Carbon::now()->format('Y-m-d')
                ]);

            }
            if ($request->Choice == "others") {
                DB::table('sxt_liabilities_mst')->insert([
                    'case_id' => $request->caseId,
                    'username' => $request->username,
                    'product_name' => $request->Remarks ?? $request->remarks,
                    'dept_id' => $request->department,
                    'amount' => 0,
                    'cleared' => 0,
                    'created_at' => Carbon::now()->format('Y-m-d')
                ]);

            }
            if ($request->filename) {
                $datafile = (object) ['filename' => $request->filename];
                foreach ($datafile->filename as $filename) {
                    $filePath = '/uploads/' . $filename;
                    $attStatus = 0;
                    DB::table('sxt_attachment_mst')->insert([
                        'attachment_name' => $filename,
                        'attachment_link' => $filePath,
                        'case_id' => $request->caseId,
                        'attachment_status' => $attStatus,
                        'created_at' => Carbon::now()->format('Y-m-d'),
                        'updated_at' => Carbon::now()->format('Y-m-d')
                    ]);
                }
            }
            if ($request->role == 'hr') {
                DB::table('sxt_case_mst')
                    ->where('case_id', $request->caseId)
                    ->update([
                        'status' => $status,
                    ]);
            } else if ($request->role == 'payroll' && $status == 2) {

                DB::table('sxt_case_mst')
                    ->where('case_id', $request->caseId)
                    ->update([
                        'status' => $status,
                        $request->role => $status,
                    ]);

            } else {
                $check_updated = DB::table('sxt_case_mst')
                    ->where('case_id', $request->caseId)
                    ->select('status')->first();

                DB::table('sxt_case_mst')
                    ->where('case_id', $request->caseId)
                    ->update([
                        $request->role => $status,
                    ]);
                if ($check_updated->status != 2) {
                    $x = $status == 3 ? 3 : 4;
                    DB::table('sxt_case_mst')
                        ->where('case_id', $request->caseId)
                        ->update(['status' => $x]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            \Log::info(json_encode($e));
            DB::rollback();
            return 'Something went wrong';
        }


    }









    public function getTotal(Request $request)
    {
        $total = DB::connection('pgsql')->table('iro_case_mst')->where('STATUS', 2)->get();
        $count = $total->count();
        return $count;
    }

    // =========== fetching total cases ===============
    public function getCompletedTotal(Request $request)
    {
        $total = DB::connection('pgsql')->table('iro_case_mst')->where('STATUS', 9)->get();
        $count = $total->count();
        return $count;
    }

    // =========== fetching In progress ===============
    public function getInprogress(Request $request)
    {
        $total = DB::connection('pgsql')->table('iro_case_mst')->where([
            ['STATUS', '=', 1],
        ])->get();


        $count = $total->count();
        return $count;
    }
    // =========== fetching total assigned ===============

    // =========== fetching total assigned ===============
    public function getDonData(Request $request)
    {
        $data = [$request->data];
        $d = explode(',', $data[0]);
        $column = $d[0];
        $username = $d[1];
        $assigned = DB::connection('pgsql')->table('iro_case_mst')
            ->where($column, $username)
            ->whereIn('STATUS', [1, 8])
            ->get();
        $countAssigned = $assigned->count();

        $inProgress = DB::connection('pgsql')->table('iro_case_mst')
            ->where($column, $username)
            ->whereIn('STATUS', [2, 3, -3, -1, -2, 4, 5, 6, 7])
            ->get();
        $countProgress = $inProgress->count();

        $completedDecisionsMade = DB::connection('pgsql')->table('iro_case_mst')
            ->where($column, $username)
            ->whereIn('STATUS', [-4, 5, 6, 9])
            ->get();
        $count_completedDecisionsMade = $completedDecisionsMade->count();

        $seriesData = array($countAssigned, $countProgress, $count_completedDecisionsMade);
        return $seriesData;
    }
    // =========== fetching Progress Cases Report ===============
    public function getProgress(Request $request)
    {
        $data = [$request->data];
        $d = explode(',', $data[0]);
        $column = $d[0];
        $username = $d[1];
        return DB::connection('pgsql')->table('iro_case_mst')
            ->where($column, $username)
            ->join('status_mst', 'iro_case_mst.STATUS', '=', 'status_mst.STATUS_ID')
            ->get();
    }
    public function getCompletedCases(Request $request)
    {
        // $data=[$request->data];
        // $d=explode(',',$data[0]);
        // $column=$d[0];
        // $username=$d[1];
        $casesCompleted = DB::connection('pgsql')->table('iro_case_mst')
            // ->where($column,$username)
            ->whereIn('STATUS', [9])
            ->get();

        return $casesCompleted;
    }
    // =========== fetching total assigned ===============
    public function getBarData(Request $request)
    {
        $seriesData = array();
        $data = $this->getDept($request);

        return $seriesData;
    }


}
