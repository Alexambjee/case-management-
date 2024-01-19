<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CaseController;
use Illuminate\Support\Facades\DB;
class SendAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */


    public function HandleEmails($caseNum,$p_no,$Staffname){
        $sender = "CMT";
        $emaildata = ['message' => "Request clearance for $Staffname 
        personal number $p_no,Issued by $sender.
        Log in to the StaffExit tool (KRAHUB insightcmt) to clear the case.",
        'username' => $sender
        ];
        $caseController = new CaseController();
        $caseController->sendAlerts($caseNum, $emaildata);
    }
    public function handle()
    {
        
     $results2 = DB::connection('pgsql')
     ->table('sxt_case_mst')
     ->where('ICT_ACCOUNT4',0)
     ->whereIn('ICT_ACCOUNT1', [2, 3])
     ->whereIn('ICT_ACCOUNT2', [2, 3])
     ->whereIn('ICT_ACCOUNT3', [2, 3])
     ->whereIn('ICT_VPN', [2, 3])
     ->get();
     if ($results2->count()>0){
        foreach ($results2 as $result) {
            $this->HandleEmails( $result->case_id, $result->user_name, $result->employee_name);
            DB::connection('pgsql')->table('sxt_case_mst')
            ->where('case_id', $result->case_id)
            ->update(['ICT_ACCOUNT4' => 1]);
            print('Found case ID: ' . $result->case_id . "\n");
        }
     }
     $results = DB::connection('pgsql')->table('sxt_case_mst')
     ->where('payroll',0)
     ->whereIn('medical', [2, 3])
     ->whereIn('training', [2, 3])
     ->whereIn('medical', [2, 3])
     ->whereIn('security', [2, 3])
     ->whereIn('facilities_housing', [2, 3])
     ->whereIn('facilities_assets', [2, 3])
     ->whereIn('knowledge_capture', [2, 3])
     ->whereIn('library', [2, 3])
     ->whereIn('ICT_Asset', [2, 3])
     ->whereIn('ICT_ACCOUNT4', [2, 3])
     ->whereIn('own_department', [2, 3])
     ->get();
     if ($results->count()>0){
        foreach ($results as $result) {
            $this->HandleEmails( $result->case_id, $result->user_name, $result->employee_name);

            DB::connection('pgsql')->table('sxt_case_mst')
            ->where('case_id', $result->case_id)
            ->update(['payroll' => 1]);
        \Log::info('Found case ID payroll: ' . $result->case_id . "\n");
        }
     }




    }
}





    //     if ($hr_role =='payroll'){   
    //         $data = explode(',', $request->data);
    //         $status = $data[0];
    //         $role = $data[1];
    //         $role_desc = $data[2] ?? null ;
    //         // \Log::info($status);
    //         return DB::connection('pgsql')->table('sxt_case_mst')
    //             ->whereColumn($role_desc, '=', DB::raw($status))
    //             // ->whereIn('medical', [2, 3])
    //             // ->whereIn('training', [2, 3])
    //             // ->whereIn('medical', [2, 3])
    //             // ->whereIn('security', [2, 3])
    //             // ->whereIn('facilities_housing', [2, 3])
    //             // ->whereIn('facilities_assets', [2, 3])
    //             // ->whereIn('knowledge_capture', [2, 3])
    //             // ->whereIn('library', [2, 3])
    //             // ->whereIn('ICT_Asset', [2, 3])
    //             // ->whereIn('ICT_ACCOUNT4', [2, 3])
    //             // ->whereIn('own_department', [2, 3])
    //         ->where(function ($query) use ($search_1) {
    //             $query->orwhere('user_name', 'like', '%' . $search_1 . '%')
    //                 ->orWhere('employee_name', 'like', '%' . $search_1 . '%')
    //                 ->orWhere('user_name', 'like', '%' . $search_1 . '%');
    //         })
    //         ->leftjoin('sxt_status_info', 'sxt_case_mst.'.$role_desc, '=', 'sxt_status_info.status_id')
    //         ->skip($skip)->take($items_per_page)
    //         ->get();

    // }if($hr_role =='ICT_ACCOUNT4'){

    //         $data = explode(',', $request->data);
    //         $status = $data[0];
    //         $role = $data[1];
    //         $role_desc = $data[2] ?? null ;
    //         return DB::connection('pgsql')->table('sxt_case_mst')
    //             ->whereColumn($role_desc, '=', DB::raw($status))
    //             // ->whereIn('ICT_ACCOUNT1', [2, 3])
    //             // ->whereIn('ICT_ACCOUNT2', [2, 3])
    //             // ->whereIn('ICT_ACCOUNT3', [2, 3])
    //             // ->whereIn('ICT_VPN', [2, 3])
    //         ->where(function ($query) use ($search_1) {
    //             $query->orwhere('user_name', 'like', '%' . $search_1 . '%')
    //                 ->orWhere('employee_name', 'like', '%' . $search_1 . '%')
    //                 ->orWhere('user_name', 'like', '%' . $search_1 . '%');
    //         })
    //         ->leftjoin('sxt_status_info','sxt_case_mst.'.$role_desc, '=', 'sxt_status_info.status_id')
    //         ->skip($skip)->take($items_per_page)
    //         ->get();
    // }